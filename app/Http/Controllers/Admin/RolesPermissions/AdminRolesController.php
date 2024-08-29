<?php

namespace App\Http\Controllers\Admin\RolesPermissions;

use App\Actions\Admin\RolesPermissions\GetRolesWithPermissionsAction;
use App\Exceptions\RoleException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleStoringRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AdminRolesController extends Controller
{
    public function index(GetRolesWithPermissionsAction $rolesPermissions): View
    {
        [$roles, $permissions] = $rolesPermissions->handle();

        return view('admin.roles-permissions', [
            'roles' => $roles,
            'allPermissions' => $permissions,
            'guards' => array_keys(config('auth.guards')),
        ]);
    }

    public function storeRole(RoleStoringRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            Role::create(['name' => $data['role'], 'guard_name' => $data['guard']]);
        } catch (\Throwable $e) {
            throw new RoleException($e);
        }

        return back()->with('role-created', trans('alerts.roles.created'));
    }

    public function delete(Role $role): RedirectResponse
    {
        return $role->delete() >= 1
            ? back()->with('role-removed', 'Role was successfully removed.')
            : back()->with('role-not-found', 'Role not found. Try again.');
    }
}