$(function () {

    var uri_segment = document.URL.split('/')[document.URL.split('/').length-1];

    if(uri_segment == 'urls'){
        get_urls();
    }
});
function activateDeactivateUrl(id, status) {
    if (status) {
        st = "Activate";
    } else {
        st = "Deactivate"
    }
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to " + st + " this url ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ' + st + ' it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "post",
                data: {
                    "_token": CSRF_TOKEN,
                    id: id,
                    status: status
                },
                url: APP_URL + "/admin/activate-deactivate-url",
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.msg,
                        icon: 'success',
                        showCancelButton: false,
                    }).then((result) => {
                        get_urls();
                    })
                },
                error: function (error) {
                    Swal.fire({
                        title: "Error",
                        text: error.responseJSON.msg,
                        icon: "error",
                    });
                }
            });
        }
    });
}

function deleteUrl(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this url ? you won't be able to revert",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "get",
                url: APP_URL + "/admin/delete-url/"+id,
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.msg,
                        icon: 'success',
                        showCancelButton: false,
                    }).then((result) => {
                        get_urls();
                    })
                },
                error: function (error) {
                    Swal.fire({
                        title: "Error",
                        text: error.responseJSON.msg,
                        icon: "error",
                    });
                }
            });
        }
    });
}

function getSingleUrl(id) {
    $.ajax({
        method: "get",
        url: APP_URL + "/admin/get-url/" + id,
        success: function (response) {
            $("#update-url-modal").modal("show");
            $("#id").val(response.res.id);
            $("#original_url").val(response.res.original_url);
            $("#short_url").val(response.res.short_url);
            $("#expiry").val(response.res.expiry)
            // $("#expiry").datepicker({ defaultDate: response.res.expiry });
        },
    });

}

function updateUrl() {
    $.ajax({
        method: "post",
        url: APP_URL + "/admin/update-url",
        data: {
            "_token": CSRF_TOKEN,
            "id": $("#id").val(),
            "original_url": $("#original_url").val(),
            "short_url": $("#short_url").val(),
            "expiry": $("#expiry").val(),
        },
        success: function (response) {
            Swal.fire({
                title: 'Success!',
                text: response.msg,
                icon: 'success',
                showCancelButton: false,
            }).then((result) => {
                $("#update-url-modal").modal("hide");
                get_urls();
            })
        },
        error: function (error) {
            Swal.fire({
                title: "Error",
                text: error.responseJSON.msg,
                icon: "error",
            });
        }
    });

}
function updateProfile() {
    $.ajax({
        method: "post",
        url: APP_URL + "/admin/update-profile",
        data: {
            "_token": CSRF_TOKEN,
            "id": $("#id").val(),
            "email": $("#email").val(),
            "name": $("#name").val(),
        },
        success: function (response) {
            Swal.fire({
                title: 'Success!',
                text: response.msg,
                icon: 'success',
                showCancelButton: false,
            }).then((result) => {
                window.location.reload();
            })
        },
        error: function (error) {
            Swal.fire({
                title: "Error",
                text: error.responseJSON.msg,
                icon: "error",
            });
        }
    });

}

function get_urls() {

    $("#user-datatable").DataTable({
        // "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "scrollX": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "bDestroy": true,
        "ordering":false,
        ajax: {
            url:APP_URL+"/admin/get-all-urls",
            type:"GET",
        },
        "columns": [
            { mData: 'sno' } ,
            { mData: 'original_url' },
            { mData: 'short_url' },
            { mData: 'expiry' },
            { mData: 'action' }
        ]

    }).buttons().container().appendTo('#user-datatable_wrapper .col-md-6:eq(0)');
}
