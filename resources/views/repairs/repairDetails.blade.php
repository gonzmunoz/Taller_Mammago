@extends('layout.layout')

@section('additional-header')

@endsection

@section('content')
    <!-- contact area -->
    <div class="section-full content-inner">
        <!-- Product -->
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 m-b30">
                    <h4>{{ trans('messages.repairData') }}</h4>
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6">
                            <span class="font-weight-bold text-danger">{{ trans('messages.repairState') }}</span>
                            <input type="hidden" id="repairId" name="repairId"
                                   value="{{ \Illuminate\Support\Facades\Crypt::encryptString($repair['id']) }}">
                            <input type="hidden" id="idMotor" name="idMotor"
                                   value="{{ $repair['id_motor'] }}">
                            <input type="text" class="form-control" disabled
                                   value="{{ $repair['estado']}}"
                                   name="estado">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6">
                            <span class="font-weight-bold text-danger">{{ trans('messages.spentTime') }}</span>
                            <input type="text" class="form-control" disabled
                                   placeholder="{{ trans('messages.spentTime') }}"
                                   value="{{ $repair['tiempo_empleado'] . ' ' . trans('messages.hours') }}"
                                   name="tiempo_empleado" id="tiempo_empleado">
                            @if($errors->has('tiempo_empleado'))
                                <span class="text-danger">{{ $errors->first('tiempo_empleado') }}</span>
                            @endif
                        </div>
                    </div>
                    @if(session('userLogged')['id_tipo_usuario']==3 && $repair['estado'] != "Completada")
                        <div class="row">
                            <div class="form-group col-lg-8 col-md-8 col-sm-8">
                                <a class="site-button text-white mt-3"
                                   id="completeRepair">{{ trans('messages.completeRepair') }}</a>
                            </div>
                        </div>
                    @endif
                    <h4>{{ trans('messages.repairWorks') }}</h4>
                    <div class="row" id="workRow">
                        @if(empty($works))
                            <div class="form-group col-lg-8 col-md-8 col-sm-8">
                                <span class="text-danger">{{ trans('messages.noWorks') }}</span>
                                @if(session('userLogged')['id_tipo_usuario']==3 && $repair['estado'] != "Completada")
                                    <a class="site-button text-white mt-3"
                                       id="addWork">{{ trans('messages.addWork') }}</a>
                                @endif
                            </div>
                        @else
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <table class="table-bordered check-tbl">
                                    <thead style="background-color: #EE3131">
                                    <tr>
                                        <th class="text-center text-light">{{ trans('messages.workDescription') }}</th>
                                        <th class="text-center text-light">{{ trans('messages.workTimeSpent') }}</th>
                                        @if(session('userLogged')['id_tipo_usuario']==3 && $repair['estado'] != "Completada")
                                            <th class="text-center text-light">{{ trans('messages.editWork') }}</th>
                                            <th class="text-center text-light">{{ trans('messages.deleteWork') }}</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody id="workBody">
                                    @foreach($works as $work)
                                        <tr class="alert" id="rowWork{{ $work['id'] }}">
                                            <td class="product-item-name text-center">{{ $work['descripcion'] }}</td>
                                            <td class="product-item-price text-center">{{ $work['tiempo_empleado'] . ' ' . trans('messages.hours') }}</td>
                                            @if(session('userLogged')['id_tipo_usuario']==3 && $repair['estado'] != "Completada")
                                                <td class="product-item-close text-center">
                                                    <a class="fas fa-edit upWork"
                                                       idWork="{{ $work['id'] }}"></a>
                                                </td>
                                                <td class="product-item-close text-center">
                                                    <a class="fa fa-times delWork"
                                                       idWork="{{ $work['id'] }}"></a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if(session('userLogged')['id_tipo_usuario']==3 && $repair['estado'] != "Completada")
                                    <a class="site-button text-white mt-3"
                                       id="addWork">{{ trans('messages.addWork') }}</a>
                                @endif
                            </div>
                        @endif
                    </div>
                    <h4>{{ trans('messages.repairPieces') }}</h4>
                    <div class="row" id="replacementRow">
                        @if(empty($replacements))
                            <div class="form-group col-lg-8 col-md-8 col-sm-8">
                                <span class="text-danger">{{ trans('messages.noReplacements') }}</span>
                                @if(session('userLogged')['id_tipo_usuario']==3 && $repair['estado'] != "Completada")
                                    <a class="site-button text-white mt-3"
                                       id="addReplacement">{{ trans('messages.addReplacement') }}</a>
                                @endif
                            </div>
                        @else
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <table class="table-bordered check-tbl">
                                    <thead class="text-left" style="background-color: #EE3131" class="text-light">
                                    <tr>
                                        <th class="text-center text-light">{{ trans('messages.replacementName') }}</th>
                                        <th class="text-center text-light">{{ trans('messages.replacementPrice') }}</th>
                                        <th class="text-center text-light">{{ trans('messages.replacementQuantity') }}</th>
                                        @if(session('userLogged')['id_tipo_usuario']==3 && $repair['estado'] != "Completada")
                                            <th class="text-center text-light">{{ trans('messages.editReplacement') }}</th>
                                            <th class="text-center text-light">{{ trans('messages.deleteReplacement') }}</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody id="replacementBody">
                                    @foreach($replacements as $replacement)
                                        <tr class="alert" id="rowReplacement{{ $replacement['id'] }}">
                                            <td class="product-item-name text-center">{{ $replacement['nombre'] }}</td>
                                            <td class="product-item-price text-center">{{ $replacement['precio'] . ' €' }}</td>
                                            <td class="product-item-name text-center">{{ $replacement['cantidad'] }}</td>
                                            @if(session('userLogged')['id_tipo_usuario']==3 && $repair['estado'] != "Completada")
                                                <td class="product-item-close text-center">
                                                    <a class="fas fa-edit upReplacement"
                                                       idReplacement="{{ $replacement['id'] }}"></a>
                                                </td>
                                                <td class="product-item-close text-center">
                                                    <a class="fa fa-times delReplacement"
                                                       idReplacement="{{ $replacement['id'] }}"></a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if(session('userLogged')['id_tipo_usuario']==3 && $repair['estado'] != "Completada")
                                    <a class="site-button text-white mt-3"
                                       id="addReplacement">{{ trans('messages.addReplacement') }}</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 m-b30"
                     style="background: center center no-repeat url('{{ assetFtp('images/repairDetails.jpg') }}'); background-size:
                         contain">
                </div>
            </div>
        </div>
        <!-- Product END -->
    </div>
    <!-- contact area  END -->
@endsection

@section('additional-scripts')
    <script>

        $("#addWork").on("click", addWork);

        function addWork() {
            var addForm = '<input type="text" id="description" class="swal2-input" placeholder="{{ trans('messages.workDescription') }}">' +
                '<input type="text" id="hours" class="swal2-input" placeholder="{{ trans('messages.workTimeSpent') }}">';
            Swal.fire({
                title: "{{ trans('messages.addWork') }}",
                html: addForm,
                confirmButtonText: "{{ trans('messages.add') }}",
                focusConfirm: false,
                showCancelButton: true,
                cancelButtonText: "{{ trans('messages.cancelAdd') }}",
                preConfirm: () => {
                    const description = Swal.getPopup().querySelector('#description').value;
                    const hours = Swal.getPopup().querySelector('#hours').value;
                    if (!description || !hours) {
                        Swal.showValidationMessage("{{ trans('messages.workRequired') }}");
                    } else {
                        if (!(/^[0-9]+([,.][0-9]+)?$/.test(hours))) {
                            Swal.showValidationMessage("{{ trans('messages.wrongTimeSpent') }}");
                        }
                    }

                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: '{{ route('addWork') }}',
                        data: {
                            id: $("#repairId").val(),
                            description: $("#description").val(),
                            timeSpent: $("#hours").val(),
                        },
                        success: function (data) {
                            Swal.fire({
                                title: "{{ trans('messages.workAdded') }}",
                                text: "{{ trans('messages.workSuccessfullyAdded') }}",
                                icon: "success"
                            }).then(function () {
                                if (data['numero_trabajos'] <= 1) {
                                    $("#workRow div").remove();
                                    $("#workRow").append(
                                        "<div class='form-group col-lg-12 col-md-12 col-sm-12'>" +
                                        "<table class='table-bordered check-tbl'>" +
                                        "<thead class='text-left' style='background-color: #EE3131' class='text-light'>" +
                                        "<tr id='rowWork" + data['id_trabajo'] + "'>" +
                                        "<th class='text-center text-light'>{{ trans('messages.workDescription') }}</th>" +
                                        "<th class='text-center text-light'>{{ trans('messages.workTimeSpent') }}</th>" +
                                        "<th class='text-center text-light'>{{ trans('messages.editWork') }}</th>" +
                                        "<th class='text-center text-light'>{{ trans('messages.deleteWork') }}</th>" +
                                        "</tr>" +
                                        "</thead>" +
                                        "<tbody id='workBody'>" +
                                        "<tr class='alert'>" +
                                        "<td class='product-item-name text-center'>" + data['descripcion'] + "</td>" +
                                        "<td class='product-item-price text-center'>" + data['tiempo_empleado'] + " " + "{{ trans('messages.hours') }}</td>" +
                                        "<td class='product-item-close text-center'>" +
                                        "<a class='fas fa-edit upWork' idWork='" + data['id_trabajo'] + "'</a>" +
                                        "</td>" +
                                        "<td class='product-item-close text-center'>" +
                                        "<a class='fa fa-times delWork' idWork='" + data['id_trabajo'] + "'></a>" +
                                        "</td>" +
                                        "</tr>" +
                                        "</tbody>" +
                                        "</table>" +
                                        "<a class='site-button text-white mt-3' id='addWork'>{{ trans('messages.addWork') }}</a>" +
                                        "</div>"
                                    );
                                    $("#addWork").on("click", addWork);
                                } else {
                                    $(document).find("#workBody").append(
                                        "<tr class='alert' id='rowWork" + data['id_trabajo'] + "'>" +
                                        "<td class='product-item-name text-center'>" + data['descripcion'] + "</td>" +
                                        "<td class='product-item-price text-center'>" + data['tiempo_empleado'] + " " + "{{ trans('messages.hours') }}</td>" +
                                        "<td class='product-item-close text-center'>" +
                                        "<a class='fas fa-edit upWork' idWork='" + data['id_trabajo'] + "'></a>" +
                                        "</td>" +
                                        "<td class='product-item-close text-center'>" +
                                        "<a class='fa fa-times delWork' idWork='" + data['id_trabajo'] + "'></a>" +
                                        "</td>"
                                    );
                                }

                                $("#tiempo_empleado").val(data['tiempo_total']);
                            });
                        }, error: function (xhr, ajaxOptions, thrownError) {
                            console.log(thrownError);
                        }
                    });
                }
            })
        }

        $(document).on("click", ".upWork", function (e) {
            e.preventDefault();
            var clickedRow = $(this).closest("tr").attr("id");
            var workId = $(this).attr("idWork");
            $.ajax({
                type: "GET",
                url: '{{ route('getWorkData') }}',
                data: {
                    id: $(this).attr("idWork"),
                },
                success: function (data) {
                    var addForm = '<input type="text" id="description" class="swal2-input" placeholder="{{ trans('messages.replacementName') }}" value="' + data['descripcion'] +
                        '"><input type="text" id="hours" class="swal2-input" placeholder="{{ trans('messages.replacementPrice') }}" value="' + data['tiempo_empleado'] + '">';
                    Swal.fire({
                        title: "{{ trans('messages.updateWork') }}",
                        html: addForm,
                        confirmButtonText: "{{ trans('messages.update') }}",
                        focusConfirm: false,
                        showCancelButton: true,
                        cancelButtonText: "{{ trans('messages.cancelAdd') }}",
                        preConfirm: () => {
                            const description = Swal.getPopup().querySelector('#description').value;
                            const hours = Swal.getPopup().querySelector('#hours').value;
                            if (!description || !hours) {
                                Swal.showValidationMessage("{{ trans('messages.workRequired') }}");
                            } else {
                                if (!(/^[0-9]+([,.][0-9]+)?$/.test(hours))) {
                                    Swal.showValidationMessage("{{ trans('messages.wrongTimeSpent') }}");
                                }
                            }

                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "GET",
                                url: '{{ route('updateWork') }}',
                                data: {
                                    id: workId,
                                    description: $("#description").val(),
                                    timeSpent: $("#hours").val(),
                                },
                                success: function (data) {
                                    Swal.fire({
                                        title: "{{ trans('messages.workUpdated') }}",
                                        text: "{{ trans('messages.workSuccessfullyUpdated') }}",
                                        icon: "success"
                                    }).then(function () {
                                        $("#" + clickedRow).replaceWith(
                                            "<tr class='alert' id='rowWork" + data['id_trabajo'] + "'>" +
                                            "<td class='product-item-name text-center'>" + data['descripcion'] + "</td>" +
                                            "<td class='product-item-price text-center'>" + data['tiempo_empleado'] + " " + "{{ trans('messages.hours') }}</td>" +
                                            "<td class='product-item-close text-center'>" +
                                            "<a class='fas fa-edit upWork' idWork='" + data['id_trabajo'] + "'></a>" +
                                            "</td>" +
                                            "<td class='product-item-close text-center'>" +
                                            "<a class='fa fa-times delWork' idWork='" + data['id_trabajo'] + "'></a>" +
                                            "</td>"
                                        );
                                    });
                                }, error: function (xhr, ajaxOptions, thrownError) {
                                    console.log(thrownError);
                                }
                            });
                        }
                    })
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            });

        });

        $(document).on("click", ".delWork", function (e) {
            e.preventDefault();
            var clickedRow = $(this).closest("tr").attr("id");
            Swal.fire({
                title: "{{ trans('messages.confirmMessage') }}",
                text: "{{ trans('messages.confirmDeleteWork') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "{{ trans('messages.notDelete') }}",
                confirmButtonText: "{{ trans('messages.delete') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: '{{ route('deleteWork') }}',
                        data: {
                            id: $(this).attr("idWork"),
                            repairId: $("#repairId").val(),
                        },
                        success: function (data) {
                            Swal.fire({
                                title: "{{ trans('messages.workDeleted') }}",
                                text: "{{ trans('messages.workSuccessfullyDeleted') }}",
                                icon: "success"
                            }).then(function () {
                                if (data['numero_trabajos'] < 1) {
                                    $("#workRow div").remove();
                                    $("#workRow").append(
                                        "<div class='form-group col-lg-8 col-md-8 col-sm-8'>" +
                                        "<span class='text-danger'>{{ trans('messages.noWorks') }}</span>" +
                                        "<a class='site-button text-white mt-3' id='addWork'>{{ trans('messages.addWork') }}</a>" +
                                        "</div>"
                                    );
                                    $("#addWork").on("click", addWork);
                                } else {
                                    $("#" + clickedRow).remove();
                                }

                            });
                        }, error: function (xhr, ajaxOptions, thrownError) {
                            console.log(thrownError);
                        }
                    });
                }
            })

        });

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $("#addReplacement").on("click", addReplacement);

        function addReplacement() {
            var addForm = '<select id="category" class="swal2-input">' +
                '<option value="selectCategory">{{ trans('messages.selectCategory') }}</option>' +
                '<option value="1">Aceites</option>' +
                '<option value="9">Dirección</option>' +
                '<option value="8">Escape</option>' +
                '<option value="4">Frenado</option>' +
                '<option value="3">Limpieza de cristales</option>' +
                '<option value="5">Motor</option>' +
                '<option value="10">Neumáticos</option>' +
                '<option value="2">Sistema eléctrico</option>' +
                '<option value="6">Suspensión</option>' +
                '<option value="7">Transmisión</option>' +
                '</select>' +
                '<select id="newReplacement" class="swal2-input">' +
                '<option value="selectCategory">{{ trans('messages.selectReplacement') }}</option>' +
                '</select>' +
                '<input type="text" id="quantity" class="swal2-input" placeholder="{{ trans('messages.replacementQuantity') }}">';
            Swal.fire({
                title: "{{ trans('messages.addReplacement') }}",
                html: addForm,
                confirmButtonText: "{{ trans('messages.add') }}",
                focusConfirm: false,
                showCancelButton: true,
                cancelButtonText: "{{ trans('messages.cancelAdd') }}",
                preConfirm: () => {
                    const category = Swal.getPopup().querySelector('#category option:checked').value;
                    const replacement = Swal.getPopup().querySelector('#newReplacement option:checked').value;
                    const quantity = Swal.getPopup().querySelector('#quantity').value;

                    var stock = 0;
                    var articleExists = "false";

                    $.ajax({
                        type: "GET",
                        async: false,
                        url: '{{ route('checkArticleInRepair') }}',
                        data: {
                            replacementId: $("#newReplacement option:selected").val(),
                            repairId: $("#repairId").val(),
                        },
                        success: function (data) {
                            articleExists = data;
                        }, error: function (xhr, ajaxOptions, thrownError) {
                            console.log(thrownError);
                        }
                    });

                    if (articleExists == "true") {
                        Swal.showValidationMessage("{{ trans('messages.articleExists') }}");
                    }

                    if (!quantity) {
                        Swal.showValidationMessage("{{ trans('messages.quantityRequired') }}");
                    } else {
                        if (!(/^[1-9]\d*$/.test(quantity))) {
                            Swal.showValidationMessage("{{ trans('messages.wrongQuantity') }}");
                        } else {
                            $.ajax({
                                type: "GET",
                                async: false,
                                url: '{{ route('checkStock') }}',
                                data: {
                                    id: $("#newReplacement option:selected").val(),
                                    toUpdate: false,
                                    quantity: $("#quantity").val(),
                                },
                                success: function (data) {
                                    stock = data;
                                }, error: function (xhr, ajaxOptions, thrownError) {
                                    console.log(thrownError);
                                }
                            });

                            if (parseInt(stock) < parseInt(quantity)) {
                                Swal.showValidationMessage("{{ trans('messages.noStock') }}");
                            }
                        }
                    }

                    if (replacement == "selectCategory") {
                        Swal.showValidationMessage("{{ trans('messages.noReplacement') }}");
                    } else if (replacement == "noReplacements") {
                        Swal.showValidationMessage("{{ trans('messages.noReplacementsRepair') }}");
                    }

                    if (category == "selectCategory") {
                        Swal.showValidationMessage("{{ trans('messages.noCategory') }}");
                    }

                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: '{{ route('addReplacement') }}',
                        data: {
                            repairId: $("#repairId").val(),
                            replacementId: $("#newReplacement option:selected").val(),
                            quantity: $("#quantity").val(),
                        },
                        success: function (data) {
                            Swal.fire({
                                title: "{{ trans('messages.replacementAdded') }}",
                                text: "{{ trans('messages.replacementSuccessfullyAdded') }}",
                                icon: "success"
                            }).then(function () {
                                if (data['numero_repuestos'] <= 1) {
                                    $("#replacementRow div").remove();
                                    $("#replacementRow").append(
                                        "<div class='form-group col-lg-12 col-md-12 col-sm-12'>" +
                                        "<table class='table-bordered check-tbl'>" +
                                        "<thead class='text-left' style='background-color: #EE3131' class='text-light'>" +
                                        "<tr id='rowReplacement" + data['id_repuesto'] + "'>" +
                                        "<th class='text-center text-light'>{{ trans('messages.replacementName') }}</th>" +
                                        "<th class='text-center text-light'>{{ trans('messages.replacementPrice') }}</th>" +
                                        "<th class='text-center text-light'>{{ trans('messages.replacementQuantity') }}</th>" +
                                        "<th class='text-center text-light'>{{ trans('messages.editReplacement') }}</th>" +
                                        "<th class='text-center text-light'>{{ trans('messages.deleteReplacement') }}</th>" +
                                        "</tr>" +
                                        "</thead>" +
                                        "<tbody id='replacementBody'>" +
                                        "<tr class='alert'>" +
                                        "<td class='product-item-name text-center'>" + data['nombre'] + "</td>" +
                                        "<td class='product-item-price text-center'>" + data['precio'] + " €" + "</td>" +
                                        "<td class='product-item-price text-center'>" + data['cantidad'] + "</td>" +
                                        "<td class='product-item-close text-center'>" +
                                        "<a class='fas fa-edit upReplacement' idReplacement='" + data['id_repuesto'] + "'</a>" +
                                        "</td>" +
                                        "<td class='product-item-close text-center'>" +
                                        "<a class='fa fa-times delReplacement' idReplacement='" + data['id_repuesto'] + "'></a>" +
                                        "</td>" +
                                        "</tr>" +
                                        "</tbody>" +
                                        "</table>" +
                                        "<a class='site-button text-white mt-3' id='addReplacement'>{{ trans('messages.addReplacement') }}</a>" +
                                        "</div>"
                                    );
                                    $("#addReplacement").on("click", addReplacement);
                                } else {
                                    $(document).find("#replacementBody").append(
                                        "<tr class='alert' id='rowReplacement" + data['id_repuesto'] + "'>" +
                                        "<td class='product-item-name text-center'>" + data['nombre'] + "</td>" +
                                        "<td class='product-item-price text-center'>" + data['precio'] + " €" + "</td>" +
                                        "<td class='product-item-price text-center'>" + data['cantidad'] + "</td>" +
                                        "<td class='product-item-close text-center'>" +
                                        "<a class='fas fa-edit upReplacement' idReplacement='" + data['id_repuesto'] + "'></a>" +
                                        "</td>" +
                                        "<td class='product-item-close text-center'>" +
                                        "<a class='fa fa-times delReplacement' idReplacement='" + data['id_repuesto'] + "'></a>" +
                                        "</td>"
                                    );
                                }

                            });
                        }, error: function (xhr, ajaxOptions, thrownError) {
                            console.log(thrownError);
                        }
                    });
                }
            })
        }

        $(document).on("change", "#category", function () {
            $.ajax({
                type: "GET",
                url: '{{ route('getReplacements') }}',
                data: {
                    engineId: $("#idMotor").val(),
                    categoryId: $("#category option:selected").val(),
                },
                success: function (data) {
                    var message = "{{ trans('messages.noReplacementsRepair') }}";
                    $("#newReplacement option:gt(0)").remove();
                    if (Array.isArray(data)) {
                        $(data).each((ind, ele) => {
                            $("#newReplacement").append("<option value='" + ele.id + "'>" + ele.nombre + "</option>");
                        });
                    } else {
                        $("#newReplacement").append("<option value='noReplacements'>" + message + "</option>");
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            })
        });

        $(document).on("click", ".upReplacement", function (e) {
            e.preventDefault();
            var clickedRow = $(this).closest("tr").attr("id");
            var replacementId = $(this).attr("idReplacement");
            $.ajax({
                type: "GET",
                url: '{{ route('getReplacementData') }}',
                data: {
                    id: $(this).attr("idReplacement"),
                },
                success: function (data) {
                    var oldReplacementname = data['nombre'];
                    var addForm = '<select id="category" class="swal2-input">' +
                        '<option value="selectCategory">{{ trans('messages.selectCategory') }}</option>' +
                        '<option value="1">Aceites</option>' +
                        '<option value="9">Dirección</option>' +
                        '<option value="8">Escape</option>' +
                        '<option value="4">Frenado</option>' +
                        '<option value="3">Limpieza de cristales</option>' +
                        '<option value="5">Motor</option>' +
                        '<option value="10">Neumáticos</option>' +
                        '<option value="2">Sistema eléctrico</option>' +
                        '<option value="6">Suspensión</option>' +
                        '<option value="7">Transmisión</option>' +
                        '</select>' +
                        '<select id="newReplacement" class="swal2-input">' +
                        '<option value="selectCategory">{{ trans('messages.selectReplacement') }}</option>' +
                        '</select>' +
                        '<input type="text" id="quantity" class="swal2-input" placeholder="{{ trans('messages.replacementQuantity') }}" value="' + data['cantidad'] + '">';

                    setTimeout(function () {
                        $("#category option[value='" + data['categoria'] + "']").attr("selected", "selected");

                        $.ajax({
                            type: "GET",
                            url: '{{ route('getReplacements') }}',
                            data: {
                                engineId: $("#idMotor").val(),
                                categoryId: $("#category option:selected").val(),
                            },
                            success: function (data) {
                                var message = "{{ trans('messages.noReplacementsRepair') }}";
                                $("#newReplacement option:gt(0)").remove();
                                if (Array.isArray(data)) {
                                    $(data).each((ind, ele) => {
                                        $("#newReplacement").append("<option value='" + ele.id + "'>" + ele.nombre + "</option>");
                                    });
                                } else {
                                    $("#newReplacement").append("<option value='noReplacements'>" + message + "</option>");
                                }
                                $('#newReplacement option:contains("' + oldReplacementname + '")').prop('selected', true);
                            }, error: function (xhr, ajaxOptions, thrownError) {
                                console.log(thrownError);
                            }
                        });
                    }, 100);

                    Swal.fire({
                        title: "{{ trans('messages.updateReplacement') }}",
                        html: addForm,
                        confirmButtonText: "{{ trans('messages.update') }}",
                        focusConfirm: false,
                        showCancelButton: true,
                        cancelButtonText: "{{ trans('messages.cancelAdd') }}",
                        preConfirm: () => {
                            const category = Swal.getPopup().querySelector('#category option:checked').value;
                            const replacement = Swal.getPopup().querySelector('#newReplacement option:checked').value;
                            const quantity = Swal.getPopup().querySelector('#quantity').value;

                            var stock = 0;
                            var articleExists = "false";

                            $.ajax({
                                type: "GET",
                                async: false,
                                url: '{{ route('checkArticleInRepair') }}',
                                data: {
                                    replacementId: $("#newReplacement option:selected").val(),
                                    repairId: $("#repairId").val(),
                                },
                                success: function (data) {
                                    articleExists = data;
                                }, error: function (xhr, ajaxOptions, thrownError) {
                                    console.log(thrownError);
                                }
                            });

                            if (!quantity) {
                                Swal.showValidationMessage("{{ trans('messages.quantityRequired') }}");
                            } else {
                                if (!(/^[1-9]\d*$/.test(quantity))) {
                                    Swal.showValidationMessage("{{ trans('messages.wrongQuantity') }}");
                                } else {
                                    $.ajax({
                                        type: "GET",
                                        async: false,
                                        url: '{{ route('checkStock') }}',
                                        data: {
                                            id: $("#newReplacement option:selected").val(),
                                            toUpdate: true,
                                            quantity: $("#quantity").val(),
                                            idReplacement: replacementId,
                                        },
                                        success: function (data) {
                                            stock = data;
                                        }, error: function (xhr, ajaxOptions, thrownError) {
                                            console.log(thrownError);
                                        }
                                    });

                                    if (parseInt(stock) < parseInt(quantity)) {
                                        Swal.showValidationMessage("{{ trans('messages.noStock') }}");
                                    }
                                }
                            }

                            if (replacement == "selectCategory") {
                                Swal.showValidationMessage("{{ trans('messages.noReplacement') }}");
                            } else if (replacement == "noReplacements") {
                                Swal.showValidationMessage("{{ trans('messages.noReplacementsRepair') }}");
                            }

                            if (category == "selectCategory") {
                                Swal.showValidationMessage("{{ trans('messages.noCategory') }}");
                            }

                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "GET",
                                url: '{{ route('updateReplacement') }}',
                                data: {
                                    //id: replacementId,
                                    replacementId: $("#newReplacement option:selected").val(),
                                    quantity: $("#quantity").val(),
                                },
                                success: function (data) {
                                    Swal.fire({
                                        title: "{{ trans('messages.replacementUpdated') }}",
                                        text: "{{ trans('messages.replacementSuccessfullyUpdated') }}",
                                        icon: "success"
                                    }).then(function () {
                                        $("#" + clickedRow).replaceWith(
                                            "<tr class='alert' id='rowReplacement" + data['id_repuesto'] + "'>" +
                                            "<td class='product-item-name text-center'>" + data['nombre'] + "</td>" +
                                            "<td class='product-item-price text-center'>" + data['precio'] + " €" + "</td>" +
                                            "<td class='product-item-price text-center'>" + data['cantidad'] + "</td>" +
                                            "<td class='product-item-close text-center'>" +
                                            "<a class='fas fa-edit upReplacement' idReplacement='" + data['id_repuesto'] + "'></a>" +
                                            "</td>" +
                                            "<td class='product-item-close text-center'>" +
                                            "<a class='fa fa-times delReplacement' idReplacement='" + data['id_repuesto'] + "'></a>" +
                                            "</td>"
                                        );
                                    });
                                }, error: function (xhr, ajaxOptions, thrownError) {
                                    console.log(thrownError);
                                }
                            });
                        }
                    })
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            });

        });


        $(document).on("click", ".delReplacement", function (e) {
            e.preventDefault();
            var clickedRow = $(this).closest("tr").attr("id");
            Swal.fire({
                title: "{{ trans('messages.confirmMessage') }}",
                text: "{{ trans('messages.confirmDeleteReplacement') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "{{ trans('messages.notDelete') }}",
                confirmButtonText: "{{ trans('messages.delete') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: '{{ route('deleteReplacement') }}',
                        data: {
                            id: $(this).attr("idReplacement"),
                        },
                        success: function (data) {
                            Swal.fire({
                                title: "{{ trans('messages.replacementDeleted') }}",
                                text: "{{ trans('messages.replacementSuccessfullyDeleted') }}",
                                icon: "success"
                            }).then(function () {
                                if (data['numero_repuestos'] < 1) {
                                    $("#replacementRow div").remove();
                                    $("#replacementRow").append(
                                        "<div class='form-group col-lg-8 col-md-8 col-sm-8'>" +
                                        "<span class='text-danger'>{{ trans('messages.noReplacements') }}</span>" +
                                        "<a class='site-button text-white mt-3' id='addReplacement'>{{ trans('messages.addReplacement') }}</a>" +
                                        "</div>"
                                    );
                                } else {
                                    $("#" + clickedRow).remove();
                                }

                            });
                        }, error: function (xhr, ajaxOptions, thrownError) {
                            console.log(thrownError);
                        }
                    });
                }
            })

        });


        $(document).on("click", "#completeRepair", function (e) {
            e.preventDefault();
            var clickedRow = $(this).closest("tr").attr("id");

            $.ajax({
                type: "GET",
                url: '{{ route('checkWorks') }}',
                data: {
                    repairId: $("#repairId").val(),
                },
                success: function (data) {
                    if (data > 0) {
                        Swal.fire({
                            title: "{{ trans('messages.confirmMessage') }}",
                            text: "{{ trans('messages.confirmCompleteRepair') }}",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            cancelButtonText: "{{ trans('messages.notComplete') }}",
                            confirmButtonText: "{{ trans('messages.complete') }}"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "GET",
                                    url: '{{ route('completeRepair') }}',
                                    data: {
                                        repairId: $("#repairId").val(),
                                    },
                                    success: function (data) {
                                        Swal.fire({
                                            title: "{{ trans('messages.repairCompleted') }}",
                                            text: "{{ trans('messages.repairSuccessfullyCompleted') }}",
                                            icon: "success"
                                        }).then(function () {
                                            window.location.replace(" {{ route('listRepairs') }}");
                                        });
                                    }, error: function (xhr, ajaxOptions, thrownError) {
                                        console.log(thrownError);
                                    }
                                });
                            }
                        })
                    } else {
                        Swal.fire({
                            title: "{{ trans('messages.cantCompleteRepair') }}",
                            text: "{{ trans('messages.cantCompleteRepairMessage') }}",
                            icon: "error"
                        });
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
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
