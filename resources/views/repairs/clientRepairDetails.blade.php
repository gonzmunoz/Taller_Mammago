@extends('layout.layout')

@section('additional-header')

@endsection

@section('content')
    <div class="section-full content-inner">
        <!-- Product -->
        <div class="container">
            <h4>{{ trans('messages.repairNumber') . ': ' . $repair['id']  }}</h4>
            <h4>{{ trans('messages.repairState') . ': ' . $repair['estado']  }}</h4>
            @if($repair['fecha_fin'] != null)
                <h4>{{ trans('messages.repairCompletedAt') . ' ' . date('d-m-Y',  substr(strtotime($repair['fecha_fin']), 0, 10))}} </h4>
            @endif
            <div class="dlab-divider bg-gray-dark text-gray-dark icon-center"><i
                    class="fa fa-circle bg-white text-gray-dark"></i></div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <h4>{{ trans('messages.replacements') }}</h4>
                    @if(empty($replacements))
                        <div class="form-group col-lg-8 col-md-8 col-sm-8">
                            <span class="text-danger">{{ trans('messages.noReplacements') }}</span>
                        </div>
                    @else
                        <table class="table-bordered check-tbl">
                            <thead class="text-left">
                            <tr>
                                <th class="text-center">{{ trans('messages.replacement') }}</th>
                                <th class="text-center">{{ trans('messages.replacementName') }}</th>
                                <th class="text-center">{{ trans('messages.replacementPrice') }}</th>
                                <th class="text-center">{{ trans('messages.replacementQuantity') }}</th>
                                <th class="text-center">{{ trans('messages.total') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($replacements as $replacement)
                                <tr class="alert">
                                    <td class="product-item-img text-center"><img
                                            src="{{ assetFtp('images/articles/') . $replacement['imagen'] }}"
                                            alt="">
                                    </td>
                                    <td class="product-item-name text-center">{{ $replacement['nombre'] }}</td>
                                    <td class="product-item-price text-center">{{ $replacement['precio'] . ' ' . '€' }}</td>
                                    <td class="product-item-quantity text-center">{{ $replacement['cantidad'] }}</td>
                                    <td class="product-item-totle text-center">
                                        {{ ($replacement['precio'] * $replacement['cantidad']) . ' ' . '€' }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
                <div class="col-lg-6 col-md-6">
                    <h4>{{ trans('messages.repairWorks') }}</h4>
                    @if(empty($works))
                        <div class="form-group col-lg-8 col-md-8 col-sm-8">
                            <span class="text-danger">{{ trans('messages.noWorks') }}</span>
                        </div>
                    @else
                        <table class="table-bordered check-tbl">
                            <thead class="text-left">
                            <tr>
                                <th class="text-center">{{ trans('messages.workDescription') }}</th>
                                <th class="text-center">{{ trans('messages.workTimeSpent') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($works as $work)
                                <tr class="alert">
                                    <td class="product-item-name text-center">{{ $work['descripcion'] }}</td>
                                    <td class="product-item-price text-center"> {{ $work['tiempo_empleado'] . ' ' . trans('messages.hours') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <h4>{{ trans('messages.repairTotal') }}</h4>
                    <table class="table-bordered check-tbl">
                        <tbody>
                        <tr>
                            <td>{{ trans('messages.workforceTotal') }}</td>
                            <td id="subtotal">{{ $repair['totalTrabajos'] .' €' }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('messages.replacementsTotal') }}</td>
                            <td id="subtotal">{{ $repair['totalRepuestos'] .' €' }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('messages.total') }}</td>
                            <td id="total">{{ $repair['total'] .' €' }}</td>
                        </tr>
                        </tbody>
                    </table>
                    @if($repair['estado']=="Completada")
                        @if($repair['pagada']==1)
                            <div class="form-group">
                                <a href="{{ route('printRepair', \Illuminate\Support\Facades\Crypt::encryptString($repair['id']))}}"
                                   class="site-button button-lg btn-block text-white"><i
                                        class="far fa-file-pdf"></i> {{ trans('messages.printPdf') }}</a>
                            </div>
                        @else
                            @if(session('userLogged')['id_tipo_usuario']==4)
                                <div class="form-group">
                                    <a href="{{ route('payRepairWithPayPal', \Illuminate\Support\Facades\Crypt::encryptString($repair['id']))}}"
                                       class="site-button button-lg btn-block text-white">{{ trans('messages.payRepair') }}</a>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <!-- Product END -->
    </div>
    <!-- contact area  END -->
@endsection

@section('additional-scripts')
    <script>

    </script>

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
