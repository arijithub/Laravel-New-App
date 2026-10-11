@extends('layouts.app')

@section('content')
<section class="py-4">
  <div class="container-fluid">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
          class="img-fluid" alt="Create an account">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form method="POST" action="{{ route('register') }}">
          @csrf

          <h1 class="h3 mb-4">Create your account</h1>
          @if ($errors->any())
            <div class="alert alert-danger" role="alert">
              <strong>Please check the following:</strong>
              <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div data-mdb-input-init class="form-outline mb-4">
            <input type="text" id="name" name="name" value="{{ old('name') }}"
              class="form-control form-control-lg" placeholder="Enter your name" required autofocus />
            <label class="form-label" for="name">Name</label>
            @error('name')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="email" name="email" value="{{ old('email') }}"
              class="form-control form-control-lg" placeholder="Enter a valid email address" required />
            <label class="form-label" for="email">Email address</label>
            @error('email')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" id="password" name="password"
              class="form-control form-control-lg" placeholder="Enter password" required />
            <label class="form-label" for="password">Password</label>
            @error('password')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" id="password_confirmation" name="password_confirmation"
              class="form-control form-control-lg" placeholder="Confirm password" required />
            <label class="form-label" for="password_confirmation">Confirm password</label>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account?
              <a href="{{ route('login') }}" class="link-danger">Login</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
