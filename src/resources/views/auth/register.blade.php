@extends('layouts.app')

@section('content')
<section class="vh-100 ">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form form method="POST" action="{{ route('register') }}">
            @csrf
          <div class="divider d-flex align-items-center my-4">
            <h1 class="text-center fw-bold mx-3 mb-0">Sign Up</h1>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="username" placeholder="Enter username" type="text" class="form-control form-control-lg @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
            <label class="form-label" for="form3Example3">{{ __('UserName') }}</label>
             @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
          </div>
          <!-- Email input -->
          <div data-mdb-input-init class="form-outline mb-4">
               <input id="email" type="email" placeholder="Enter a valid email address" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <label class="form-label" for="form3Example3">{{ __('Email Address') }}</label>
             @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
          </div>

          <!-- Password input -->
          <div data-mdb-input-init class="form-outline mb-3">
            <input id="password" type="password" placeholder="Enter password" class="form-control @error('password') is-invalid @enderror form-control-lg" name="password" required autocomplete="current-password">
            <label class="form-label" for="form3Example4">Password</label>
             @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>
          <div data-mdb-input-init class="form-outline mb-3">
                <div class="col-md-6">
                    <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password">
                </div>
                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Do have an account? <a href="{{ route('login') }}"
                class="link-danger">Login</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>

@endsection
