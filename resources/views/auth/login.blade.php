

@extends('layouts.auth')

@section('page-title')
    {{ __('Login') }}
@endsection
@php
    $logo = Utility::get_superadmin_logo();
    $logos=\App\Models\Utility::get_file('uploads/logo/');
    $setting = \App\Models\Utility::settings();
@endphp
@section('content')

    <div class="auth-wrapper auth-v3">
        <div class="bg-auth-side bg-primary"></div>
        <div class="auth-content">
            <nav class="navbar navbar-expand-md navbar-light default">
                <div class="container-fluid pe-2">
                    <a class="navbar-brand" href="#">
                        <img src="{{ 'http://localhost:8000/assets/images/logo-new.png?'.time()}}" alt="logo" style="width:70px;">
                        {{-- <img src="{{ $logos.$logo .'?'.time()}}" alt="logo" style="width:150px;"> --}}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01" style="flex-grow: 0;">
                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                            {{-- <li class="nav-item">
                                <a class="nav-link active" href="{{ route('home') }}">{{ __('Create Ticket') }}</a>
                            </li> --}}
                            <li class="nav-item">
                                @if ($setting['FAQ'] == 'on')
                                    <a class="nav-link" href="{{ route('faq') }}">{{ __('FAQ') }}</a>
                                @endif
                            </li>
                            <li class="nav-item">
                                @if ($setting['Knowlwdge_Base'] == 'on')
                                    <a href="{{route('knowledge')}}" class="nav-link">{{ __('Knowledge') }}</a>
                                @endif
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('search') }}">{{ __('Search Ticket') }}</a>
                            </li>
                            <li class="nav-item">

                                <select name="language" id="language" class="btn btn-primary my-1 me-2  language_option_bg" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                    @foreach(App\Models\Utility::languages() as $code  => $language)
                                    <option @if($code == $lang) selected @endif value="{{ route('login',$code) }}">{{Str::ucfirst($language)}}</option>
                                @endforeach
                                </select>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">

                            </li>
                        </ul>
                    </div>
                </div>
            </nav>


            <div class="card">
                <div class="row align-items-center text-start">
                    <div class="col-xl-6">
                        <div class="card-body">
                            <div class="d-flex">
                                <h2 class="mb-3 f-w-600">{{ __('Login') }}</h2>
                            </div>
                            <form method="POST" action="{{ route('login') }}" id="form_data">
                                @csrf
                                @if (session()->has('info'))
                                    <div class="alert alert-success">
                                        {{ session()->get('info') }}
                                    </div>
                                @endif
                                @if (session()->has('status'))
                                    <div class="alert alert-info">
                                        {{ session()->get('status') }}
                                    </div>
                                @endif

                                <div class="">
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label d-flex">{{ __('Email') }}</label>

                                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                            id="email" name="email" placeholder="{{ __('Email address') }}" required="">
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('email') }}
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex" >{{ __('Password') }}</label>
                                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="{{ __('Enter Password') }}" required="">
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('password') }}
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <a href="{{ route('password.request') }}" class="d-block mt-2"><small>{{ __('Forgot password?') }}</small>
                                        </a>
                                    </div>
                                    @if (env('RECAPTCHA_MODULE') == 'yes')
                                    <div class="form-group mb-3 mt-3 ">
                                        {!! NoCaptcha::display() !!}
                                        @error('g-recaptcha-response')
                                        <span class="small text-danger" role="alert" >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                @endif
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-block mt-2" id="login_button">{{ __('Login') }}</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="col-xl-6 img-card-side">
                        <div class="auth-img-content">
                            <img src="{{ asset('assets/images/auth/img-auth-3.svg') }}" alt="" class="img-fluid">
                            <h3 class="text-white mb-4 mt-5">{{ __('“Perhatian Anda adalah nilai yang kami hargai di aplikasi dukungan kami.”')}}</h3>
                            <p class="text-white">
                                {{ __('Ketika kami membuat segalanya terlihat mudah, itu karena kami berusaha sebaik mungkin untuk memudahkan pengalaman Anda. Kami di sini untuk membantu dengan sepenuh hati.')}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted">{{env('FOOTER_TEXT')}}</p>
                        </div>
                        <div class="col-6 text-end">
                            {{-- <p class="text-white">{{ __('© 2022, made with love for a better web.') }} </p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
@if (env('RECAPTCHA_MODULE') == 'yes')
{!! NoCaptcha::renderJs() !!}
@endif
    <script>
    $(document).ready(function () {
        $("#form_data").submit(function (e) {
            $("#login_button").attr("disabled", true);
            return true;
        });
    });
    </script>
@endpush

