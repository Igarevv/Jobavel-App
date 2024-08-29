@php use App\Enums\Admin\AdminDeletedUserSearchEnum;use Illuminate\Contracts\Pagination\Paginator; @endphp
<x-admin.layout>
    <x-admin.header>
        <x-slot:title>Users > Temporarily Deleted</x-slot:title>
        In this section, you can manage with temporarily deleted users
    </x-admin.header>

    <section class="mx-auto w-3/4 my-10">
        <x-admin.table.default>
            <x-slot:title>Temporarily deleted users</x-slot:title>
            <x-slot:description>You can restore temporarily deleted users
                <div>
                    <div class="text-center">
                        <form class="max-w-lg mx-auto" action="{{ route('admin.temporarily-deleted.search') }}"
                              method="GET">
                            <div class="flex">
                                @php
                                    $input = $input ?? null;
                                @endphp
                                <div class="relative">
                                    <select id="custom-select" name="searchBy"
                                            class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600 appearance-none">
                                        <option value="" disabled selected>Choose column</option>
                                        @foreach (AdminDeletedUserSearchEnum::columns() as $value => $label)
                                            <option value="{{ $value }}" @selected(old('searchBy') === $value || $input?->searchById === $value)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="relative w-full">
                                    <input type="search" id="search-dropdown" name="search"
                                           value="{{ old('search') ?? $input?->search }}"
                                           class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-s-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-red-500"
                                           placeholder="Search..."/>
                                    <button type="submit"
                                            class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-red-700 rounded-e-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                  stroke-linejoin="round" stroke-width="2"
                                                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                        <span class="sr-only">Search</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        @error('searchBy')
                        <span class="text-red-100 text-sm">{{ $message }}</span>
                        @enderror
                        @error('search')
                        <span class="text-red-100 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </x-slot:description>
            <x-admin.table.thead>
                <th scope="col" class="px-3 py-3 text-sm">No.</th>
                <th scope="col" class="px-3 py-3 text-sm">User Id</th>
                <th scope="col" class="px-3 py-3 text-sm">Email</th>
                <th scope="col" class="px-3 py-3 text-sm">Created At</th>
                <th scope="col" class="px-3 py-3 text-sm">Deleted At</th>
                <th scope="col" class="px-3 py-3 text-sm"></th>
            </x-admin.table.thead>
            <x-admin.table.tbody>
                @forelse($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            @if($users instanceof Paginator)
                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                            @else
                                {{ $loop->iteration }}
                            @endif
                        </th>
                        <td class="px-3 py-4">
                            {{ $user->idEncrypted }}
                        </td>
                        <td class="px-3 py-4">
                            {{ $user->email }}
                        </td>
                        <td class="px-3 py-4">
                            {{ $user->createdAt }}
                        </td>
                        <td class="px-3 py-4">
                            {{ $user->deletedAt }}
                        </td>
                        <td class="px-3 py-4">
                            <form action="{{ route('admin.temporarily-deleted.restore', ['identity' => $user->id]) }}"
                                  method="POST">
                                @csrf
                                <button type="submit"
                                        class="unstyled-button font-medium text-green-400 dark:text-white hover:underline">
                                    Restore
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-6">
                     <span class="text-xl text-gray-500 dark:text-gray-400">
                         @isset($input)
                             Temporarily deleted user with key:
                             <span class="font-bold underline">{{ $input->searchByValue }}</span>
                             and search value:
                             <span class="font-bold underline">{{ $input->search }}</span>
                             not found
                         @else
                             Temporarily deleted users not found
                         @endisset
                     </span>
                        </td>
                    </tr>
                @endforelse
            </x-admin.table.tbody>
        </x-admin.table.default>
        <div class="mt-1">
            @if ($users instanceof Paginator )
                {{ $users->withQueryString()->links() }}
            @endif
        </div>
    </section>
</x-admin.layout>