<x-layout>

    <x-slot:heading>
        @include('components/basehead')
    </x-slot:heading>

    <x-slot:footer>
        @include('components/basefooter')
    </x-slot:footer>

    <div class="mt-5 background-badge">
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light"><strong @style(['color:white'])>Job<span @style(['color:#f9322c'])>avel</span></strong></h1>
                    <p class="lead text-light">Find or post developers jobs</p>
                    <div class="d-flex justify-content-center align-items-center flex-row">
                        <div class="text-center">
                            <p class="text-white m-2">↓ I'm an Employee</p>
                            <a href="/employee/register" class="btn btn-danger mx-2">Start finding job</a>
                            <a href="/employer/register" class="btn btn-danger mx-2">Start posting job</a>
                            <p class="text-white m-2">I'm an Employer ↑</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="album py-5 bg-body-tertiary">
        <div class="container">

            <div class="row my-4">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search Laravel Gigs...">
                </div>
                <div class="col-auto">
                    <button class="btn btn-danger">Search</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 job-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Senior Developer | Laravel & Vue</h5>
                            <p class="card-text">Wonka Industries</p>
                            <div>
                                <span class="badge bg-dark text-light">laravel</span>
                                <span class="badge bg-dark text-light">api</span>
                                <span class="badge bg-dark text-light">vue</span>
                            </div>
                            <p class="card-text"><small class="text-muted">Miami, FL</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 job-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Backend Engineer</h5>
                            <p class="card-text">Skynet Systems</p>
                            <div>
                                <span class="badge bg-dark text-light">laravel</span>
                                <span class="badge bg-dark text-light">backend</span>
                                <span class="badge bg-dark text-light">api</span>
                            </div>
                            <p class="card-text"><small class="text-muted">Boston, MA</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 job-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Laravel Developer</h5>
                            <p class="card-text">Wayne Enterprises</p>
                            <div>
                                <span class="badge bg-dark text-light">laravel</span>
                                <span class="badge bg-dark text-light">vue</span>
                                <span class="badge bg-dark text-light">api</span>
                            </div>
                            <p class="card-text"><small class="text-muted">Gotham, NY</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 job-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Junior Developer</h5>
                            <p class="card-text">Stark Industries</p>
                            <div>
                                <span class="badge bg-dark text-light">laravel</span>
                                <span class="badge bg-dark text-light">html</span>
                                <span class="badge bg-dark text-light">css</span>
                            </div>
                            <p class="card-text"><small class="text-muted">Newark, NJ</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
