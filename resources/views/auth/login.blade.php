@extends('layouts.login.app')
@section('content')
<div class="sw_container">
  <div class="my-form">
    <div class="form-div">
      <a href="{{ route('login') }}" class="mb-7">
        <img src="assets/media/logos/logo.jpg" class="logo" alt="Switch">
      </a>
      <form class="form w-100" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-back">
          <div class="form-input">
            <div class="single-input">
              <span class="icon-span"><i class="fas fa-user"></i></span>
              <input type="text" placeholder="SAP-ID" name="username" value="{{ old('username') }}" required autofocus class="form-control @error('username') is-invalid @enderror" />
              @error('username')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="single-input">
              <span class="icon-span"><i class="fas fa-lock"></i></span>
              <input type="password" placeholder="Password" name="password" required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror" />
            </div>
            @if($errors->any())
            {!! implode('', $errors->all('<span style="color:red;">:message</span>')) !!}
            @endif
          </div>
          <div class="single-input submit-btn">
            <input type="submit" value="LOGIN">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection