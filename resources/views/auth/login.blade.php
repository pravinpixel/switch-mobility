@extends('layouts.login.app')
@section('content')

<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page bg image-->
    <style>
        /* body {
            background-image: url('assets/media/auth/bg4.jpg');
        } */

        [data-theme="dark"] body {
            background-image: url('assets/media/auth/bg4-dark.jpg');
        }
    </style>
    <!--end::Page bg image-->
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <!--begin::Aside-->
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <!--begin::Aside-->
            <div class="d-flex flex-center flex-lg-start flex-column">
                <!--begin::Logo-->
                <a href="{{ route('login') }}" class="mb-7">
                    <img alt="Logo" src="assets/media/logos/limage.png" />
                </a>
                <!--end::Logo-->
                <!--begin::Title-->
                <h2 class="text-white fw-normal m-0"></h2>
                <!--end::Title-->
            </div>
            <!--begin::Aside-->
        </div>
        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-center w-lg-50 p-10 "  style="background: #3270e3;">
            <!--begin::Card-->
            <div class="card rounded-3 w-md-550px">
                <!--begin::Card body-->
                <div class="card-body p-10 p-lg-20">
                    <!--begin::Form-->
                    <form class="form w-100" method="POST" action="{{ route('login') }}">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-dark fw-bolder mb-3">Login Control Panel</h1>
                            <!--end::Title-->

                        </div>
                        <!--begin::Input group=-->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input type="text" placeholder="SAP-ID" name="username" value="{{ old('username') }}" required autofocus class="form-control bg-transparent @error('username') is-invalid @enderror" />
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <!--end::Email-->
                        </div>
                        <!--end::Input group=-->
                        <div class="fv-row mb-3">
                            <!--begin::Password-->
                            <input type="password" placeholder="Password" name="password" required autocomplete="current-password" class="form-control bg-transparent @error('password') is-invalid @enderror" />

                            <!--end::Password-->
                        </div>
                        @if($errors->any())
                        {!! implode('', $errors->all('<span style="color:red;">:message</span>')) !!}
                        @endif
                        <!--end::Input group=-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <div></div>
                            <!--begin::Link-->
                            <a href="{{ route('password.request') }}" class="link-primary"></a>
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Submit button-->
                        <div class="d-grid mb-10">
                            <button type="submit" id="kt_sign_in_submit" class="btn switchPrimaryBtn">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">Log In</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                        </div>
                        <!--end::Submit button-->

                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
@endsection