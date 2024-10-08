@php
    use App\Enums\Admin\AdminVacanciesSearchEnum as SearchEnum;
@endphp
<x-admin.layout>
    <x-admin.header>
        <x-slot:title>Vacancies</x-slot:title>
        In this section, you can view all vacancies that are published and unpublished Also, you can manage this vacancies, but some action are
        limited depending on your permissions.
    </x-admin.header>

    <section class="mx-auto w-11/12 my-10">
        @session('vacancy-deleted')
        <x-admin.alerts.success>{{ $value }}</x-admin.alerts.success>
        @endsession
        <x-admin.table.default>
            <x-slot:title>
                <div class="flex flex-col">
                    <span>Vacancies</span>
                    <span>Found: <span id="foundRecords"></span> records</span>
                </div>
            </x-slot:title>
            <x-slot:description>
                <span>The full list of vacancies</span>
                <div class="flex items-center justify-between">
                    <div class="text-center items-center max-w-lg mx-auto">
                        <div class="flex">
                            <div class="relative">
                                <select id="searchBy"
                                        name="searchBy"
                                        class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600 appearance-none">
                                    <option disabled selected hidden value>Choose column</option>
                                    @foreach (SearchEnum::columns() as $value => $label)
                                        <option value="{{ $value }}" @selected(old('searchBy') === $value)>
                                            {{ $label }}
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
                <th scope="col" class="px-3 py-3 text-sm">Title</th>
                <th scope="col" class="px-3 py-3 text-sm">Status</th>
                <th scope="col" class="px-3 py-3 text-sm">Employment Type</th>
                <th scope="col" class="px-3 py-3 text-sm">
                    <button type="button"
                            class="sort-link flex items-center space-x-1" data-sort="responses"
                            data-direction="desc">
                        <span class="uppercase">Response Number</span>
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
                <th scope="col" class="px-3 py-3 text-sm">Employer Info</th>
                <th scope="col" class="px-3 py-3 text-sm">
                    <button type="button"
                            class="sort-link flex items-center space-x-1" data-sort="creation-time"
                            data-direction="desc">
                        <span class="uppercase">Created at</span>
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
                <th scope="col" class="px-3 py-3 text-sm">
                    <button type="button"
                            class="sort-link flex items-center space-x-1" data-sort="published-time"
                            data-direction="desc">
                        <span class="uppercase">Published At</span>
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
            <x-admin.table.tbody class="vacancies-body">
                <!--From JS-->
            </x-admin.table.tbody>
        </x-admin.table.default>
        <div class="pagination-container">
            <!-- Pagination from same JS -->
        </div>

    </section>

    <div id="static-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white" id="modal-header"></h3>
                    <button type="button" class="hide-modal-btn text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="medium-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <div class="modal-loading-overlay" id="modal-loading-overlay">
                        <div role="status" id="loading-spinner">
                            <svg aria-hidden="true"
                                 class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-red-600"
                                 viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                      fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                      fill="currentFill"/>
                            </svg>
                            <span class="sr-only text-black">Loading...</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="" id="employer-logo" alt="Employer Logo"/>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white" id="company"></h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400" id="type"></span>
                    </div>
                    <div class="flex flex-col">
                        <div class="mb-3">
                            <span class="font-medium text-gray-900 dark:text-white">Contact email:</span>
                            <div class="text-center">
                                <span class="text-gray-500 dark:text-gray-400" id="contact-email"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <span class="font-medium text-gray-900 dark:text-white">Created at:</span>
                            <div class="text-center">
                                <span class="text-gray-500 dark:text-gray-400" id="created-at"></span>
                            </div>
                        </div>
                        <div>
                            <span class="font-medium text-gray-900 dark:text-white">Employer ID:</span>
                            <div class="text-center">
                                <span class="text-sm text-gray-500 dark:text-gray-400" id="employer-id"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="static-modal" type="button" class="hide-modal-btn py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                </div>
            </div>
        </div>
    </div>

    @pushonce('vite')
        @vite(['resources/assets/js/admin/tables/vacancyTable.js', 'resources/assets/js/admin/fetchEmployer.js'])
    @endpushonce
</x-admin.layout>
