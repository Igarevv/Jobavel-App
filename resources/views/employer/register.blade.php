@php use App\Enums\EmployerEnum; @endphp
<x-layout class="vh-100">
    <x-slot:title>Register</x-slot:title>
    <x-slot:injectBody>background-auth</x-slot:injectBody>

    <x-main>
        <section class="form-smaller vh-100">
            <div class="container w-100">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                        <div class="card border border-light-subtle rounded-4">
                            <div class="card-body p-3 p-md-4 p-xl-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-5">
                                            <div class="text-center mb-4">
                                                <a href="/" class="navbar-brand d-flex justify-content-center">
                                                    <strong
                                                            class="h4">Job<span class="red">avel</span></strong>
                                                </a>
                                            </div>
                                            <h2 class="h4 text-center">Company Registration</h2>
                                            <h3 class="fs-6 fw-normal text-secondary text-center m-0">Enter your details
                                                to
                                                register</h3>
                                        </div>
                                    </div>
                                </div>
                                <form action="" method="post">
                                    @csrf
                                    <div class="row gy-3 overflow-hidden">
                                        <x-input.block class="col-12">
                                            <x-input.index type="text" name="company" id="company"
                                                           placeholder="Google Inc."
                                                           label="Company name" value="{{ old('company') }}"
                                                           required></x-input.index>
                                            @error('company')
                                            <p class="text-danger fst-italic fw-bolder h6">{{ $message }}</p>
                                            @enderror
                                        </x-input.block>
                                        <x-input.block class="col-12">
                                            <x-input.index type="email" name="email" id="email"
                                                           placeholder="index@mail.com"
                                                           label="Email" value="{{ old('email') }}"
                                                           required></x-input.index>
                                            @error('email')
                                            <p class="text-danger fst-italic fw-bolder h6">{{ $message }}</p>
                                            @enderror
                                        </x-input.block>
                                        <div class="col-12">
                                            <h6 class="fw-bold">Company type</h6>
                                            <select class="form-select" required name="type">
                                                <option value="{{ EmployerEnum::COMPANY_TYPE_PRODUCT->value }}"
                                                        {{ old('type') === EmployerEnum::COMPANY_TYPE_PRODUCT->value ? 'selected' : '' }}>
                                                    Product
                                                </option>
                                                <option value="{{ EmployerEnum::COMPANY_TYPE_OUTSOURCE->value }}"
                                                        {{ old('type') === EmployerEnum::COMPANY_TYPE_OUTSOURCE->value ? 'selected' : '' }}>
                                                    Outsource
                                                </option>
                                                <option value="{{ EmployerEnum::COMPANY_TYPE_AGENCY->value }}"
                                                        {{ old('type') === EmployerEnum::COMPANY_TYPE_AGENCY->value ? 'selected' : '' }}>
                                                    Agency
                                                </option>
                                                <option value="{{ EmployerEnum::COMPANY_TYPE_OUTSTAFF->value }}"
                                                        {{ old('type') === EmployerEnum::COMPANY_TYPE_OUTSTAFF->value ? 'selected' : '' }}>
                                                    Outstaff
                                                </option>
                                            </select>
                                            @error('type')
                                            <p class="text-danger fst-italic fw-bolder h6">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <x-input.block class="col-12">
                                            <x-input.index type="password" name="password" id="password"
                                                           placeholder="*******"
                                                           label="Password" required></x-input.index>
                                        </x-input.block>
                                        <x-input.block class="col-12">
                                            <x-input.index type="password" name="password_confirmation"
                                                           id="password_confirmation"
                                                           placeholder="********"
                                                           label="Confirm password" required></x-input.index>
                                            @error('password')
                                            <p class="text-danger fst-italic fw-bolder h6">{{ $message }}</p>
                                            @enderror
                                        </x-input.block>
                                        <x-input.block class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="true"
                                                       name="iAgree"
                                                       id="iAgree" required>
                                                <label class="form-check-label text-secondary" for="iAgree">
                                                    I agree to the <a href="#!"
                                                                      class="link-primary text-decoration-none">terms
                                                        and conditions</a>
                                                </label>
                                            </div>
                                        </x-input.block>
                                        <x-input.block class="col-12">
                                            <div class="d-grid">
                                                <button class="btn bsb-btn-xl btn-primary" type="submit">Sign up
                                                </button>
                                            </div>
                                        </x-input.block>
                                        @session('error')
                                        <div class="alert alert-danger text-center fw-bold">
                                            {{ $value }}
                                        </div>
                                        @endsession
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-12">
                                        <hr class="mt-5 mb-4 border-secondary-subtle">
                                        <p class="m-0 text-secondary text-center">Already have an account? <a
                                                    href="{{ route('login.show') }}"
                                                    class="link-primary text-decoration-none">Sign
                                                in</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-main>

</x-layout>
