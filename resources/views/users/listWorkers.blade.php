@extends('layout.layout')

@section('additional-header')
    <link rel="stylesheet" type="text/css"
          href="{{ assetFtp('plugins/datatable/datatables.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 m-b30">
                <div class="table-responsive">
                    <table class="table check-tbl text-center" id="users-table">
                        <thead style="background-color: #EE3131" class="text-light">
                        <tr>
                            <th class="align-middle text-white"> {{ trans('messages.photo') }}</th>
                            <th class="align-middle text-white"> {{ trans('messages.position') }}</th>
                            <th class="align-middle text-white"> {{ trans('messages.user') }}</th>
                            <th class="align-middle text-white"> {{ trans('messages.Name') }}</th>
                            <th class="align-middle text-white"> {{ trans('messages.SurName') }}</th>
                            <th class="align-middle text-white"> {{ trans('messages.email') }}</th>
                            <th class="align-middle text-white"> {{ trans('messages.phone') }}</th>
                            <th class="align-middle text-white"> {{ trans('messages.workerAuthorised') }}</th>
                            <th class="align-middle text-white"> {{ trans('messages.editWorker') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th scope="row" class="align-middle">
                                    <img src="{{ assetFtp($user['foto']) }}"
                                         class="img-fluid rounded-circle" alt="Responsive image"
                                         style="height: 42px; width: 42px;">
                                </th>
                                @if($user['id_tipo_usuario']==2)
                                    <td class="align-middle"
                                        title="{{ trans('messages.administrative') }}">{{ trans('messages.administrative') }}</td>
                                @elseif($user['id_tipo_usuario']==3)
                                    <td class="align-middle"
                                        title="{{ trans('messages.mechanic') }}">{{ trans('messages.mechanic') }}</td>
                                @else
                                    <td class="align-middle"
                                        title="{{ trans('messages.administrator') }}">{{ trans('messages.administrator') }}</td>
                                @endif
                                <td class="align-middle"
                                    title="{{ $user['nombre_usuario'] }}">{{ $user['nombre_usuario'] }}</td>
                                <td class="align-middle" title="{{ $user['nombre'] }}">{{ $user['nombre'] }}</td>
                                <td class="align-middle" title="{{ $user['apellidos'] }}">{{ $user['apellidos'] }}</td>
                                <td class="align-middle" title="{{ $user['email'] }}">{{ $user['email'] }}</td>
                                <td class="align-middle">
                                    @if($user['telefono']==null)
                                        {{ trans('messages.incompleteData') }}
                                    @else
                                        {{ $user['telefono'] }}
                                    @endif
                                </td>
                                @if($user['habilitada']==1)
                                    <td class="align-middle product-item-close-green">
                                        <a class="fas fa-user"
                                           idUser="{{ \Illuminate\Support\Facades\Crypt::encryptString($user['id']) }}"></a>
                                    </td>
                                @else
                                    <td class="align-middle product-item-close">
                                        <a class="fas fa-user-slash"
                                           idUser="{{ \Illuminate\Support\Facades\Crypt::encryptString($user['id']) }}"></a>
                                    </td>
                                @endif
                                <td class="align-middle">
                                    <a href="{{ route('viewWorker', \Illuminate\Support\Facades\Crypt::encryptString($user['id'])) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-scripts')
    <script src="{{ assetFtp('plugins/datatable/datatables.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ assetFtp('plugins/datatable/spanish-datatable.json') }}"
            type="text/javascript"></script>
    <script>

        $(window).on("load", function () {
            $(function () {
                $("#users-table").dataTable(
                    {
                        pageLength: 6,
                        "language": {
                            "url": "{{ assetFtp(trans('messages.dataTable')) }}"
                        },
                        lengthChange: false,
                        "aoColumnDefs": [
                            {"bSortable": false, "aTargets": [0, 7, 8]},
                            {"bSearchable": false, "aTargets": [0, 7, 8]},
                        ]
                    });

                $(".fa-user").on("click", function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "{{ trans('messages.confirmMessage') }}",
                        text: "{{ trans('messages.confirmDisableUser') }}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        cancelButtonText: "{{ trans('messages.notDisable') }}",
                        confirmButtonText: "{{ trans('messages.disable') }}"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "GET",
                                url: '{{ route('disableUser') }}',
                                data: {
                                    id: $(this).attr("idUser"),
                                },
                                success: function (data) {
                                    Swal.fire({
                                        title: "{{ trans('messages.userDisabled') }}",
                                        text: "{{ trans('messages.userSuccessfullyDisabled') }}",
                                        icon: "success"
                                    }).then(function () {
                                        window.location = "{{ route('listWorkers') }}";
                                    });
                                }, error: function (xhr, ajaxOptions, thrownError) {
                                    console.log(thrownError);
                                }
                            });
                        }
                    })

                });

                $(".fa-user-slash").on("click", function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "{{ trans('messages.confirmMessage') }}",
                        text: "{{ trans('messages.confirmAbleUser') }}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        cancelButtonText: "{{ trans('messages.notAble') }}",
                        confirmButtonText: "{{ trans('messages.able') }}"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "GET",
                                url: '{{ route('ableUser') }}',
                                data: {
                                    id: $(this).attr("idUser"),
                                },
                                success: function (data) {
                                    Swal.fire({
                                        title: "{{ trans('messages.userAbled') }}",
                                        text: "{{ trans('messages.userSuccessfullyAbled') }}",
                                        icon: "success"
                                    }).then(function () {
                                        window.location = "{{ route('listWorkers') }}";
                                    });
                                }, error: function (xhr, ajaxOptions, thrownError) {
                                    console.log(thrownError);
                                }
                            });
                        }
                    })

                });

            });
        });

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
