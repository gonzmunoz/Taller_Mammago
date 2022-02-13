$("#addWork").on("click", addWork);

$("#addReplacement").on("click", function () {
    var addForm = '<input type="text" id="name" class="swal2-input" placeholder="{{ trans('
    messages.replacementName
    ') }}"><input type="text" id="price" class="swal2-input" placeholder="{{ trans('
    messages.replacementPrice
    ') }}">';
    Swal.fire({
        title: "{{ trans('messages.addReplacement') }}",
        html: addForm,
        confirmButtonText: "{{ trans('messages.add') }}",
        focusConfirm: false,
        showCancelButton: true,
        cancelButtonText: "{{ trans('messages.cancelAdd') }}",
        preConfirm: () => {
            const name = Swal.getPopup().querySelector('#name').value;
            const price = Swal.getPopup().querySelector('#price').value;
            if (!name || !price) {
                Swal.showValidationMessage("{{ trans('messages.replacementRequired') }}");
            } else {
                if (!(/^[0-9]+([,.][0-9]+)?$/.test(price))) {
                    Swal.showValidationMessage("{{ trans('messages.wrongPrice') }}");
                }
            }

        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                url: '{{ route('addReplacement') }}',
                data: {
                    id: $("#repairId").val(),
                    name: $("#name").val(),
                    price: $("#price").val(),
                },
                success: function (data) {
                    Swal.fire({
                        title: "{{ trans('messages.replacementAdded') }}",
                        text: "{{ trans('messages.replacementSuccessfullyAdded') }}",
                        icon: "success"
                    }).then(function () {

                    });
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            });
        }
    })
});

function addWork() {
    var addForm = '<input type="text" id="description" class="swal2-input" placeholder="{{ trans('
    messages.workDescription
    ') }}"><input type="text" id="hours" class="swal2-input" placeholder="{{ trans('
    messages.workTimeSpent
    ') }}">';
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
            var addForm = '<input type="text" id="description" class="swal2-input" placeholder="{{ trans('
            messages.replacementName
            ') }}" value="' + data['descripcion'] +
            '"><input type="text" id="hours" class="swal2-input" placeholder="{{ trans('
            messages.replacementPrice
            ') }}" value="' + data['tiempo_empleado'] + '">';
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
