@php use App\Enums\Actions\ReasonToDeleteVacancyEnum;use App\Persistence\Models\Admin;use App\Persistence\Models\User; @endphp
<x-layout>
    <x-slot:title>{{ $vacancy->title ?? 'Jobavel' }}</x-slot:title>

    <x-header></x-header>

    @php
    $wasDeletedByAdmin = $vacancy->wasTrashedByAdmin();
    @endphp
    <x-main>
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="fst-italic text-danger fw-bold">Attention! This vacancy is trashed</h2>
                    <article>
                        <div class="d-flex align-items-center mb-4">
                            <div class="col-md-2">
                                <img src="{{ $employer->logo }}" class="img-fluid"
                                     alt="{{ $employer->company }}">
                            </div>
                            <header class="flex-grow-1 ms-3">
                                <h1 class="fw-bolder mb-1">{{ $vacancy->title }}</h1>
                                <div class="text-muted fst-italic mb-2">
                                    {{ $vacancy->published_at ? 'Posted '.$vacancy->published_at->diffForHumans() : 'Not published yet' }}
                                </div>
                                @foreach($skillSet as $skill)
                                    <span class="badge small bg-dark text-light">{{ $skill->skillName }}</span>
                                @endforeach
                            </header>
                        </div>
                        <section class="mb-5">
                            <div class="d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                     class="float-start me-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                    <path
                                            d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                                    <path
                                            d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                                </svg>
                                @if($vacancy->salary === 0)
                                    <h5 class="fw-bold fst-italic mb-0">Salary:
                                        <span class="text-warning"> negotiated salary</span>
                                    </h5>
                                @else
                                    <h5 class="fw-bold fst-italic mb-0">Salary: <span
                                                class="text-success">${{ $vacancy->salary }}</span></h5>
                                @endif
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                     class="float-start me-2" viewBox="0 0 16 16">
                                    <path
                                            d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                                    <path
                                            d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z"/>
                                </svg>
                                <h5 class="fw-bold fst-italic mb-0">About us:</h5>
                            </div>
                            <p class="fs-5 mb-4">{{ $employer->description }}</p>

                            <div class="d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                     class="float-start me-2" viewBox="0 0 16 16">
                                    <path
                                            d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                    <path
                                            d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.4 5.4 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z"/>
                                </svg>
                                <h5 class="fw-bold fst-italic mb-0">About work:</h5>
                            </div>
                            <p class="fs-5 mb-4">{{ $vacancy->description }}</p>

                            <div class="d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                     class="float-start me-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
                                    <path
                                            d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                                    <path
                                            d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                                </svg>
                                <h5 class="fw-bold fst-italic mb-0">Your responsibilities:</h5>
                            </div>
                            <ul class="mb-4 vacancy-ul">
                                @foreach($vacancy->responsibilities as $responsibility)
                                    <li class="fs-6 mb-2">{{ $responsibility }}</li>
                                @endforeach
                            </ul>

                            <div class="d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                     class="float-start me-2" viewBox="0 0 16 16">
                                    <path
                                            d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                                </svg>
                                <h5 class="fw-bold fst-italic mb-0">We expect from you:</h5>
                            </div>
                            <ul class="mb-4 vacancy-ul">
                                @foreach($vacancy->requirements as $requirement)
                                    <li class="fs-6 mb-2">{{ $requirement }}</li>
                                @endforeach
                            </ul>

                            @isset($vacancy->offers)
                                <div class="d-flex align-items-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                         class="float-start me-2" viewBox="0 0 16 16">
                                        <path
                                                d="m8 0 1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864z"/>
                                        <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1z"/>
                                    </svg>
                                    <h5 class="fw-bold fst-italic mb-0">From our side we offer:</h5>
                                </div>
                                <ul class="mb-4 vacancy-ul">
                                    @foreach($vacancy->offers as $offer)
                                        <li class="fs-6 mb-2">{{ $offer }}</li>
                                    @endforeach
                                </ul>
                            @endempty
                        </section>

                    </article>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex flex-column align-items-center gap-3">
                        <div class="card w-75 border border-dark rounded mb-4">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center fw-bold">Click to show more</h5>
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    @foreach($skillSet as $skill)
                                        <ul class="list-unstyled mb-0">
                                            <li><a href="#!">
                                            <span
                                                    class="badge small bg-dark text-light">{{ $skill->skillName }}
                                            </span>
                                                </a>
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card w-75 border border-dark rounded mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    @if($vacancy->experienceFromString() === 0)
                                        <p class="fw-bold">We are looking for employee without experience</p>
                                    @else
                                        <h6 class="fw-bold mb-0">From {{ $vacancy->experience_time }} experience</h6>
                                        @if($vacancy->consider_without_experience)
                                            <p class="text-muted text-14 font-12">We also consider a
                                                candidate without
                                                experience</p>
                                        @endif
                                    @endif
                                </div>
                                <p class="fw-bold">{{ $vacancy->employment_type }} job</p>
                                <div class="d-flex align-items-center mb-3">
                                    <h6 class="mb-0 fw-bold text-14">{{ $skillSetRow }}</h6>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                         class="float-start me-2" viewBox="0 0 16 16">
                                        <path
                                                d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                                        <path
                                                d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z"/>
                                    </svg>
                                    <h6 class="text-muted mb-0 text-14">Company: <span
                                                class="fw-bold">{{ $employer->company }}</span></h6>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                         class="float-start me-2" viewBox="0 0 16 16">
                                        <path
                                                d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                        <path
                                                d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                                        <path
                                                d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                                    </svg>
                                    <h5 class="text-muted mb-0 text-14">Company type: {{ $employer->type }}</h5>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <svg class="float-start me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         width="14" height="14">
                                        <path fill="none" d="M0 0h24v24H0z"/>
                                        <path
                                                d="M12 2C8.14 2 5 5.14 5 9c0 3.86 5 11 7 13.25C14 20 19 12.86 19 9c0-3.86-3.14-7-7-7zm0 11.5c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/>
                                    </svg>
                                    <h5 class="text-muted mb-0 text-14">Location: {{ $vacancy->location }}</h5>
                                </div>
                                <div>
                                    <span class="fw-bolder text-14">Number of applies:</span>
                                </div>
                            </div>
                        </div>
                        @role(User::EMPLOYER)
                        @can(['edit', 'delete'], $vacancy)
                            <div class="card w-75 border border-dark rounded mb-4">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-center fw-bold">Actions for you</h5>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <form
                                                    action="{{ route('employer.vacancy.restore', ['vacancy' => $vacancy->slug]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <x-button.outline colorType="success" class="w-100"
                                                                      type="submit">Restore
                                                    </x-button.outline>
                                                </form>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <form
                                                    action="{{ route('employer.vacancy.delete-forever', ['vacancy' => $vacancy->slug]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button.outline colorType="danger" class="w-100"
                                                                      type="submit">Delete forever
                                                    </x-button.outline>
                                                </form>
                                            </div>
                                        </div>
                                        @if($wasDeletedByAdmin)
                                            <div class="col-12">
                                                <x-button.default colorType="danger" id="open-button-trashed-modal" class="w-100"
                                                                  data-bs-target="#trashed-info-modal" data-bs-toggle="modal"
                                                                  data-vacancy-slug="{{ $vacancy->slug }}"
                                                                  type="button">Why this vacancy was trashed by service?
                                                </x-button.default>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endcan
                        @endrole
                        @role(Admin::ADMIN)
                        <div class="card w-75 border border-dark rounded mb-4">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center fw-bold">Admin actions</h5>
                                <div class="d-flex justify-content-center align-items-center gap-3 flex-column">
                                    @if($wasDeletedByAdmin)
                                        <x-button.default colorType="info" id="open-button-trashed-modal" class="w-100"
                                                          data-bs-target="#trashed-info-modal" data-bs-toggle="modal"
                                                          data-vacancy-slug="{{ $vacancy->slug }}"
                                                          type="button">Why this vacancy was trashed by service?
                                        </x-button.default>
                                    @endif
                                    <x-button.default class="float-end mt-3" colorType="danger"
                                                      data-bs-toggle="modal" data-bs-target="#delete-forever-modal">
                                        Permanently delete vacancy
                                    </x-button.default>
                                </div>
                            </div>
                        </div>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </x-main>
    <x-modal.index id="delete-forever-modal">
        <x-modal.withform title="Delete vacancy" btnActionName="Delete"
                          actionPath="{{ route('admin.vacancies.delete', ['vacancy' => $vacancy->slug]) }}"
                          withClose>
            <input type="checkbox" name="delete_type"
                   value="{{ \App\Enums\Admin\DeleteVacancyTypeEnum::DELETE_PERMANENTLY }}" hidden checked>
            <div class="my-2">
                <h6>Reason for deleting this vacancy (required)</h6>
                <select class="form-select" name="reason_type" aria-label="Default select example">
                    @foreach(ReasonToDeleteVacancyEnum::cases() as $enum)
                        <option value="{{ $enum->value }}" @selected($enum === ReasonToDeleteVacancyEnum::INAPPROPRIATE_CONTENT)>
                            {{ $enum->toString() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="my-2">
                <h6>Additional comment (Optional)</h6>
                <div class="input-group">
                    <x-input.textarea id="reason" name="comment"></x-input.textarea>
                </div>
            </div>
            @error('reason_type')
            <span class="text-danger text-center">{{ $message }}</span>
            @enderror
            @error('comment')
            <span class="text-danger text-center">{{ $message }}</span>
            @enderror
            @error('delete_type')
            <span class="text-danger text-center">{{ $message }}</span>
            @enderror
            @session('error')
            <span class="text-danger text-center">{{ $value }}</span>
            @endsession
        </x-modal.withform>
    </x-modal.index>

    <x-modal.index id="trashed-info-modal">
        <div class="modal-header">
            <h5 class="modal-title">Trash info</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="d-none text-center" id="not-found-trash-message">
                <h4 id="trash-message" class="fw-bold"></h4>
            </div>
            <div class="d-block" id="trash-info-content">
                <div>
                    <h5>Reason:</h5>
                    <p class="mt-3 text-center"><span class="fw-bold" id="trash-reason"></span></p>
                </div>
                <div>
                    <h5>Description:</h5>
                    <p class="mt-3"><span id="trash-description"></span></p>
                </div>
                <div class="d-none" id="optional-block">
                    <h5>Additional comments:</h5>
                    <p class="mt-3"><span id="trash-comment"></span></p>
                </div>
                <div>
                    <span class="float-end text-muted" id="trash-performed-time"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </x-modal.index>

    <x-footer></x-footer>
    @if($errors->any())
        <script type="module">
          $(document).ready(function () {
            $('#delete-forever-modal').modal('show');
          });
        </script>
    @endif

    @pushonce('vite')
        @vite(['resources/assets/js/admin/vacancyTrashInfo.js'])
    @endpushonce
</x-layout>
