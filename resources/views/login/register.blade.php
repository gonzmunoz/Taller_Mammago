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
                <div id="login" class="tab-pane active text-center">
                    <form class="p-a30 dlab-form text-center text-center" id="registerForm" method="post"
                          enctype="multipart/form-data" action="{{ route('checkRegister') }}">
                        @csrf
                        <h3 class="form-title m-t0">{{ trans('messages.Sign Up') }}</h3>
                        <div class="dlab-separator-outer m-b5">
                            <div class="dlab-separator bg-primary style-liner"></div>
                        </div>
                        <p>{{ trans('messages.registerMessage') }}</p>
                        <div class="form-group">
                            <input name="rgUserName" class="form-control"
                                   placeholder="{{ trans('messages.UserName') }}" type="text"
                                   value="{{ old('rgUserName') }}"/>
                            @if($errors->has('rgUserName'))
                                <span class="text-danger">{{ $errors->first('rgUserName') }}</span>
                            @elseif(session('error-user'))
                                <span class="text-danger">{{ session('error-user') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input name="rgName" class="form-control"
                                   placeholder="{{ trans('messages.Name') }}" type="text" value="{{ old('rgName') }}"/>
                            @if($errors->has('rgName'))
                                <span class="text-danger">{{ $errors->first('rgName') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input name="rgSurName" class="form-control"
                                   placeholder="{{ trans('messages.SurName') }}" type="text"
                                   value="{{ old('rgSurName') }}"/>
                            @if($errors->has('rgSurName'))
                                <span class="text-danger">{{ $errors->first('rgSurName') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input name="rgEmail" class="form-control"
                                   placeholder="{{ trans('messages.Email') }}" type="email"
                                   value="{{ old('rgEmail') }}"/>
                            @if($errors->has('rgEmail'))
                                <span class="text-danger">{{ $errors->first('rgEmail') }}</span>
                            @elseif(session('error-email'))
                                <span class="text-danger">{{ session('error-email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input name="rgPassword" class="form-control"
                                   placeholder="{{ trans('messages.Password') }}"
                                   type="password"/>
                            @if($errors->has('rgPassword'))
                                <span class="text-danger">{{ $errors->first('rgPassword') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input name="rgPasswordRepeated" class="form-control"
                                   placeholder="{{ trans('messages.Re-type Your Password') }}"
                                   type="password"/>
                            @if($errors->has('rgPasswordRepeated'))
                                <span class="text-danger">{{ $errors->first('rgPasswordRepeated') }}</span>
                            @elseif(session('error-password'))
                                <span class="text-danger">{{ session('error-password') }}</span>
                            @endif
                        </div>
                        <div class="form-group text-left"><a class="site-button outline gray"
                                                             href="{{ route('index') }}">{{ trans('messages.home') }}</a>
                            <button class="site-button pull-right">{{ trans('messages.Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Content END-->
@endsection
