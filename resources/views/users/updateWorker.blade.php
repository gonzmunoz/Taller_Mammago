@extends('layout.layout')

@section('additional-header')

@endsection

@section('content')
    <!-- contact area -->
    <div class="section-full content-inner">
        <!-- Product -->
        <div class="container">
            <form class="shop-form" method="post" enctype="multipart/form-data" action="{{ route('updateClient') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-lg-6 m-b30">
                        <h4>{{ trans('messages.workerData') }}</h4>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <input type="hidden" name="nombre_usuario" value="{{ $user['nombre_usuario'] }}">
                                <input type="hidden" name="id" value="{{ $user['id'] }}">
                                <span class="font-weight-bold text-danger">{{ trans('messages.Name') }}</span>
                                <input type="text" class="form-control" placeholder="{{ trans('messages.Name') }}"
                                       value="{{ old('nombre') ? old('nombre') : ucfirst($user['nombre']) }}" name="nombre">
                                @if($errors->has('nombre'))
                                    <span class="text-danger">{{ $errors->first('nombre') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.SurName') }}</span>
                                <input type="text" class="form-control" placeholder="{{ trans('messages.SurName') }}"
                                       value="{{ old('apellidos') ? old('apellidos') : ucfirst($user['apellidos']) }}" name="apellidos">
                                @if($errors->has('apellidos'))
                                    <span class="text-danger">{{ $errors->first('apellidos') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="font-weight-bold text-danger">{{ trans('messages.address') }}</span>
                            <input type="text" class="form-control" placeholder="{{ trans('messages.address') }}"
                                   value="{{ old('direccion') ? old('direccion') : ucfirst($user['direccion']) }}" name="direccion">
                            @if($errors->has('direccion'))
                                <span class="text-danger">{{ $errors->first('direccion') }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.country') }}</span>
                                <input type="text" class="form-control" placeholder="{{ trans('messages.country') }}"
                                       value="{{ old('pais') ? old('pais') : ucfirst($user['pais']) }}" name="pais">
                                @if($errors->has('pais'))
                                    <span class="text-danger">{{ $errors->first('pais') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.town') }}</span>
                                <input type="text" class="form-control" placeholder="{{ trans('messages.town') }}"
                                       value="{{ old('ciudad') ? old('ciudad') : ucfirst($user['ciudad']) }}" name="ciudad">
                                @if($errors->has('ciudad'))
                                    <span class="text-danger">{{ $errors->first('ciudad') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.state') }}</span>
                                <input type="text" class="form-control" placeholder="{{ trans('messages.state') }}"
                                       value="{{ old('provincia') ? old('provincia') : ucfirst($user['provincia']) }}" name="provincia">
                                @if($errors->has('provincia'))
                                    <span class="text-danger">{{ $errors->first('provincia') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.Email') }}</span>
                                <input type="email" class="form-control" placeholder="{{ trans('messages.Email') }}"
                                       value="{{ old('email') ? old('email') : $user['email'] }}" name="email">
                                @if($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @elseif(session('error-email'))
                                    <span class="text-danger">{{ session('error-email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.phone') }}</span>
                                <input type="text" class="form-control" placeholder="{{ trans('messages.phone') }}"
                                       value="{{ old('telefono') ? old('telefono') : ucfirst($user['telefono']) }}" name="telefono">
                                @if($errors->has('telefono'))
                                    <span class="text-danger">{{ $errors->first('telefono') }}</span>
                                @elseif(session('error-phone'))
                                    <span class="text-danger">{{ session('error-phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <button class="site-button button-lg btn-block ml-4" type="submit">{{ trans('messages.updateWorker') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 m-b30" style="background: center center no-repeat url('{{ assetFtp('images/viewWorker.jpg') }}'); background-size:
                        contain">
                    </div>
                </div>
            </form>
        </div>
        <!-- Product END -->
    </div>
    <!-- contact area  END -->
@endsection

@section('additional-scripts')
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
