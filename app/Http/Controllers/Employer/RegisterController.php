<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\DTO\Auth\RegisterEmployerDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\EmployerRegisterRequest;
use App\Service\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{

    public function __construct(
        private readonly AuthService $authService
    ) {
    }

    public function __invoke(EmployerRegisterRequest $request
    ): RedirectResponse|View {
        if ($request->isMethod('GET')) {
            return view('employer.register');
        }

        $employer = RegisterEmployerDto::fromRequest($request, config('app.default_employer_logo'));

        $this->authService->register($employer);

        return redirect()->route('login.show')->with(
            'register-success',
            trans('alerts.register.success')
        );
    }

}
