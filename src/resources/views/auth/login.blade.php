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
        <form form method="POST" action="{{ route('login') }}">
            @csrf
          <div class="divider d-flex align-items-center my-4">
            <h1 class="text-center fw-bold mx-3 mb-0">Sign in</h1>
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

          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
            <div class="form-check mb-0">
              <input class="form-check-input me-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label class="form-check-label" for="form2Example3">
                Remember me
              </label>
            </div>
            <a href="#!" class="text-body">Forgot password?</a>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ route('register') }}"
                class="link-danger">Register</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>

@endsection
