@extends('layouts.global')

@section('title', __('Login'))

@section('bodyclass', 'login')

@section('content')
<section class="section home-box">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
            </div>

            <div class="card card-primary">
              <div class="header-top">
              <!-- <img src="{{ url('images/logo/logo-uea.svg') }}" alt="logo" width="203" height="42" class="brand-login"> -->
              <h2>Lavanya Driving School</h2>
              <div class="card-header"><h4>{{ __('message.labels.login_title') }}</h4></div>
              </div>
              <div class="card-body">
   
                @if (session()->has('invalidrole'))
                    <p class="error-login">{{ session('invalidrole') }}</p>
                @endif
                <form class="form-horizontal" method="POST" action="{{ route('login') }}" autocomplete="off">
                {{ csrf_field() }}

                  <div class="form-group  @error('email') has-error @enderror">
                    <label for="email">{{ __('message.labels.email') }}</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" placeholder="{{ __('message.labels.email') }}" value="{{ old('email') }}">
                    @error('email')
                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>

                  <div class="form-group  @error('password') has-error @enderror">
                    <div class="d-block">
                      <label for="password" class="control-label">{{ __('message.labels.password') }}</label>
                      <div class="float-right" style="display:none;">
                        <a href="javascript:;" class="text-small">
                          {{ __('message.labels.forgot_password') }}
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" placeholder="{{ __('message.labels.password') }}" value="{{ old('password') }}">
                    @error('password')
                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">{{ __('message.labels.remember_me') }}</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      {{ __('message.labels.login_button') }}
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection

@section('js') 
@endsection

