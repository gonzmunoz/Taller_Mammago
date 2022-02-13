@extends('login.layout')

@section('content')
    <div class="page-content dlab-login bg-secondry">
        <div class="top-head text-center logo-header">
            <a href="{{ route('index') }}">
                <img src="{{ assetFtp('images/logo.png') }}" alt=""/>
            </a>
        </div>
        <div class="login-form">
            <div class="tab-content nav">
                <div class="tab-pane active text-center">
                    <form class="p-a30 dlab-form text-center" id="forgottenPasswordForm" method="post"
                          action="{{ route('recoverPassword') }}">
                        @csrf
                        <h3 class="form-title m-t0">{{ trans('messages.Forget Password ?') }}</h3>
                        <div class="dlab-separator-outer m-b5">
                            <div class="dlab-separator bg-primary style-liner"></div>
                        </div>
                        <p>{{ trans('messages.Enter your e-mail address below to reset your password') }}</p>
                        <div class="form-group">
                            <input name="fpEmail" class="form-control"
                                   placeholder="{{ trans('messages.Email') }}" type="email" value="{{ old('fpEmail') }}" />
                            @if($errors->has('fpEmail'))
                                <span class="text-danger">{{ $errors->first('fpEmail') }}</span>
                            @elseif(session()->has('error-email'))
                                <span class="text-danger">{{ session('error-email') }}</span>
                            @endif
                        </div>
                        <div class="form-group text-left"><a class="site-button outline gray"
                                                             href="{{ route('login') }}">{{ trans('messages.Back') }}</a>
                            <button class="site-button pull-right">{{ trans('messages.Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Content END-->
@endsection
