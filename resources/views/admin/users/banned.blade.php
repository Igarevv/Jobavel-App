@php use App\Enums\Admin\AdminBannedSearchEnum as SearchEnum;@endphp
<x-admin.layout>
    <x-admin.header>
        <x-slot:title>Users > Banned</x-slot:title>
        In this section, you can manage banned users.
    </x-admin.header>

    <section class="mx-auto w-11/12 my-10">
        @session('success-ban')
        <x-admin.alerts.success>{{ $value }}</x-admin.alerts.success>
        @endsession
        @session('error')
        <x-admin.alerts.error>{{ $value }}</x-admin.alerts.error>
        @endsession
        <x-admin.table.default>
            <x-slot:title>
                <div class="flex flex-col">
                    <span>Banned users</span>
                    <span>Found: <span id="foundRecords"></span> records</span>
                </div>
            </x-slot:title>
            <x-slot:description>
                <span>The full list of banned users</span>
                <div class="flex items-center justify-between">
                    <div class="text-center items-center max-w-lg mx-auto">
                        <div class="flex">
                            <div class="relative">
                                <select id="searchBy"
                                        name="searchBy"
                                        class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600 appearance-none">
                                    <option disabled hidden value selected>Choose column</option>
                                    @foreach (SearchEnum::cases() as $enum)
                                        <option value="{{ $enum->value }}" @selected(old('searchBy') === $enum->value)>
                                            {{ $enum->toString() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="relative w-[512px]">
                                <input type="search" id="search-dropdown"
                                       name="search"
                                       value=""
                                       class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-s-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-red-500"
                                       placeholder="Search..." required/>
                                <button type="submit" id="searchBtn"
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
                        <span class="text-sm text-red-100" id="search-validation-error"></span>
                    </div>
                    <div class="flex justify-end flex-col">
                        <button type="button" id="refreshTable"
                                class="py-2.5 px-5 me-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            Refresh
                        </button>
                        <span class="text-green-400 text-xs mt-2" id="refresh-span"></span>
                    </div>
                </div>
            </x-slot:description>
            <x-admin.table.thead>
                <th scope="col" class="px-3 py-3 text-sm">No.</th>
                <th scope="col" class="px-3 py-3 text-sm">User Id</th>
                <th scope="col" class="px-3 py-3 text-sm">Email</th>
                <th scope="col" class="px-3 py-3 text-sm">Reason</th>
                <th scope="col" class="px-3 py-3 text-sm">Comment</th>
                <th scope="col" class="px-3 py-3 text-sm">Duration</th>
                <th scope="col" class="px-3 py-3 text-sm">Will Unbanned at</th>
                <th scope="col" class="px-3 py-3 text-sm">
                    <button type="button"
                            class="sort-link flex items-center space-x-1" data-sort="banned-time"
                            data-direction="desc">
                        <span class="uppercase">Banned at</span>
                        <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" id="asc-icon"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m5 15 7-7 7 7"/>
                        </svg>
                        <svg class="w-4 h-4 text-red-100 dark:text-black" aria-hidden="true" id="desc-icon"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m19 9-7 7-7-7"/>
                        </svg>
                    </button>
                </th>
            </x-admin.table.thead>
            <x-admin.table.tbody class="banned-body">
                <!--From JS-->
            </x-admin.table.tbody>
        </x-admin.table.default>
        <div class="pagination-container">
            <!-- Pagination from same JS -->
        </div>
    </section>

    <x-admin.modal.index class="relative p-4 w-full max-w-xl max-h-full">
        <x-admin.modal.header>
            <x-slot:title>Additional comment to ban</x-slot:title>
        </x-admin.modal.header>
        <x-admin.modal.content class="content-container relative">
            <p id="ban-comment"></p>
        </x-admin.modal.content>
        <x-admin.modal.footer/>
    </x-admin.modal.index>

    @pushonce('vite')
        @vite(['resources/assets/js/admin/tables/bannedTable.js'])
    @endpushonce
</x-admin.layout>
