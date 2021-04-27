<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		@include('base::layouts.header')
	</head>
	<body onbeforeunload="blockPage();" class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-grid--hor-tablet-and-mobile m-login m-login--6">
				<div class="m-grid__item m-grid__item--fluid m-grid__item--order-tablet-and-mobile-1 m-login__wrapper" style="background-image: url('{{ asset('img/login.jpg') }}');">
					<!--begin::Body-->
					<div class="m-login__body">
						<!--begin::Signin-->
						<div class="m-login__signin">
                            <div class="m-login__logo" style="text-align: center">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('img/logo.png') }}" alt="Logo">
                                </a>
                            </div>
                            <br>
							<div class="m-login__title">
								<h3>{{ env('APP_NAME') }} - {{ __('auth.login.title') }}</h3>
								<small>{{ __('global.powered-by') }} <a class="m-link" href="{{ config('custom.dev_url') }}" rel="author" target="_blank">{{ config('custom.dev_name') }}</a></small>
							</div>
							<!--begin::Form-->
                            {!! Form::open(['class' => 'm-login__form m-form', 'route' => 'post.login', 'method' => 'POST']) !!}
                                @csrf
                                <div class="form-group m-form__group has-danger">
                                    {!! Form::input('email', 'email', '',['placeholder' => 'E-mail', 'maxlength' => '50', 'autofocus' => '', 'class' => 'form-control m-input', 'required']) !!}
                                    @if ($errors->has('email'))
                                        <div class="form-control-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group m-form__group has-danger">
                                    {!! Form::input('password', 'password', '',['placeholder' => 'Password', 'class' => 'form-control m-input', 'required']) !!}
                                    @if ($errors->has('password'))
                                        <div class="form-control-feedback has-danger">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </div>
                                    </span>
                                    @endif
                                </div>
                                <div class="m-login__action">
                                    <button type="submit" class="btn btn-primary m-btn--icon m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                            <span>
                                                <i class="fa fa-sign-in-alt"></i>
                                                <span>{{ __('auth.login.title') }}</span>
                                            </span>
                                    </button>
                                </div>
                            {!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
