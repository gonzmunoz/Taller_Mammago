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
                    <form class="p-a30 dlab-form" id="loginForm" method="post" action="{{ route('checkLogin') }}">
                        @csrf
                        <h3 class="form-title m-t0">{{ trans('messages.Sign In') }}</h3>
                        <div class="dlab-separator-outer m-b5">
                            <div class="dlab-separator bg-primary style-liner"></div>
                        </div>
                        <p>{{ trans('messages.Enter your personal details below:') }}</p>
                        <div class="form-group">
                            <input name="lgName" class="form-control"
                                   placeholder="{{ trans('messages.emailOrUser') }}" type="text" value="{{ old('lgName') }}"/>
                            @if($errors->has('lgName'))
                                <span class="text-danger">{{ $errors->first('lgName') }}</span>
                            @elseif(session('error-email'))
                                <span class="text-danger">{{ session('error-email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input name="lgPassword" class="form-control"
                                   placeholder="{{ trans('messages.Type Password') }}"
                                   type="password"/>
                            @if($errors->has('lgPassword'))
                                <span class="text-danger">{{ $errors->first('lgPassword') }}</span>
                            @elseif(session('error-password'))
                                <span class="text-danger">{{ session('error-password') }}</span>
                            @endif
                        </div>
                        <div class="form-group text-left">
                            <button class="site-button m-r5 dz-xs-flex">{{ trans('messages.Login') }}</button>
                            <a class="site-button m-r5 dz-xs-flex float-right" style="background-color: deepskyblue;"
                               href="{{ route('register') }}">{{ trans('messages.Sign Up') }}</a>
                            <div class="m-t20">
                                <a class="site-button outline gray"
                                   href="{{ route('index') }}">{{ trans('messages.home') }}</a>
                                <i class="fa fa-unlock-alt m-l60"></i>&nbsp<a href="{{ route('forgottenPassword') }}"
                                                                               class="font-weight-bold text-dark">{{ trans('messages.Forgot Password') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Content END-->
    @if(session('response-form'))
        <script>
            Swal.fire({
                icon: "{{ session('response-form')['icon'] }}",
                title: "{{ session('response-form')['title'] }}",
                text: "{{ session('response-form')['text'] }}",
            });
            $(".swal2-select").remove();
        </script>
    @endif

@endsection
