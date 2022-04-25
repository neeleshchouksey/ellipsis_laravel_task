
function onlyNumberKey(evt) {

    // Only ASCII charactar in that range allowed
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}
function readURL(input) {
    console.log(input.files[0]);
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#p-img')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function deactivateAccount(){
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to deactivate your account",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, deactivate it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "get",
                url: APP_URL + "/deactivate-account",
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
    });
}
