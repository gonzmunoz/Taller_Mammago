@extends('login.layout')

@section('content')
    <div class="page-content dlab-login bg-secondry">
        <div class="top-head text-center logo-header">
            <a href="{{ route('index') }}">
                <img src="{{ assetFtp(trans('messages.logo')) }}" alt=""/>
            </a>
        </div>
        <div class="login-form">
            <div class="tab-content nav">
                <div class="tab-pane active text-center">
                    <form class="p-a30 dlab-form text-center" id="forgottenPasswordForm" method="post"
                          action="{{ route('changePassword') }}">
                        @csrf
                        <h3 class="form-title m-t0">{{ trans('messages.Forget Password ?') }}</h3>
                        <div class="dlab-separator-outer m-b5">
                            <div class="dlab-separator bg-primary style-liner"></div>
                        </div>
                        <p>{{ trans('messages.inputNewPassword') }}</p>
                        <div class="form-group">
                            <input type="hidden" name="passwordCode" value="{{ $codigoPassword }}">
                            <input name="cpPassword" class="form-control"
                                   placeholder="{{ trans('messages.Password') }}" type="password"/>
                            @if($errors->has('cpPassword'))
                                <span class="text-danger">{{ $errors->first('cpPassword') }}</span>
                            @elseif(session('error-password'))
                                <span class="text-danger">{{ session('error-password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input name="cpPassword-repeat" class="form-control"
                                   placeholder="{{ trans('messages.repeatPassword') }}" type="password"/>
                            @if($errors->has('cpPassword-repeat'))
                                <span class="text-danger">{{ $errors->first('cpPassword-repeat') }}</span>
                            @endif
                        </div>
                        <div class="form-group text-left">
                            <button class="site-button pull-right mb-4">{{ trans('messages.Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Content END-->
@endsection
