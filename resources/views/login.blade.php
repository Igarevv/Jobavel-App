<x-layout>
    <x-slot:title>Login</x-slot:title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet">
    <x-slot:injectBody>background-auth</x-slot:injectBody>

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">
                                <div class="text-center mb-4">
                                    <a href="/" class="navbar-brand d-flex justify-content-center">
                                        <strong class="h4">Job<span @style(['color:#f9322c'])>avel</span></strong>
                                    </a>
                                </div>
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>

                                <form action="" method="post">
                                    @csrf
                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <input type="email" id="typeEmailX"
                                               class="form-control form-control-lg text-white border">
                                        <label class="form-label" for="typeEmailX">Email</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <input type="password" id="typePasswordX"
                                               class="form-control form-control-lg text-white border"/>
                                        <label class="form-label" for="typePasswordX">Password</label>
                                    </div>

                                    <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot
                                            password?</a>
                                    </p>

                                    <button data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-outline-light btn-lg px-5" type="submit">Login
                                    </button>
                                </form>
                            </div>

                            <div>
                                <p class="mb-0">Don't have an account? Sign Up<br>
                                    <a href="{{ route('employee.register') }}" class="text-white-50 fw-bold"> as
                                        Employee</a>
                                    or <a href="{{ route('employer.register') }}" class="text-white-50 fw-bold">as
                                        Employer</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
