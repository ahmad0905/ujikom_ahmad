<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH USER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="control-label">name</label>
                    <input type="text" class="form-control" id="name">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name"></div>
                </div>
                

                <div class="form-group">
                    <label for="name" class="control-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat"></div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">No telpon</label>
                    <input type="number" class="form-control" id="no_telp">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_telp"></div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">Email</label>
                    <input type="text" class="form-control" id="email">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="store">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create user event
    $('body').on('click', '#btn-create-user', function () {

        //open modal
        $('#modal-create').modal('show');
    });

    //action create user
    $('#store').click(function(e) {
        e.preventDefault();

        //define variable
        let name   = $('#name').val();
        let alamat = $('#alamat').val();
        let no_telp = $('#no_telp').val();
        let email = $('#email').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `/users`,
            type: "POST",
            cache: false,
            data: {
                "name": name,
                "alamat": alamat,
                "no_telp": no_telp,
                "email": email,
                "_token": token
            },
            success:function(response){

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                //data user
                let user = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.name}</td>
                        <td>${response.data.alamat}</td>
                        <td>${response.data.no_telp}</td>
                        <td>${response.data.email}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-user" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-user" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;
                
                //append to table
                $('#table-users').prepend(user);
                
                //clear form
                $('#name').val('');
                $('#alamat').val('');
                $('#no_telp').val('');
                $('#email').val('');

                //close modal
                $('#modal-create').modal('hide');
                

            },
            error:function(error){
                
                if(error.responseJSON.name[0]) {

                    //show alert
                    $('#alert-name').removeClass('d-none');
                    $('#alert-name').addClass('d-block');

                    //add message to alert
                    $('#alert-name').html(error.responseJSON.name[0]);
                } 

                if(error.responseJSON.alamat[0]) {

                    //show alert
                    $('#alert-alamat').removeClass('d-none');
                    $('#alert-alamat').addClass('d-block');

                    //add message to alert
                    $('#alert-alamat').html(error.responseJSON.alamat[0]);
                } 

                if(error.responseJSON.no_telp[0]) {

                    //show alert
                    $('#alert-no_telp').removeClass('d-none');
                    $('#alert-no_telp').addClass('d-block');

                    //add message to alert
                    $('#alert-no_telp').html(error.responseJSON.no_telp[0]);
                    } 

                if(error.responseJSON.email[0]) {

                    //show alert
                    $('#alert-email').removeClass('d-none');
                    $('#alert-email').addClass('d-block');

                    //add message to alert
                    $('#alert-email').html(error.responseJSON.email[0]);
                } 

            }

        });

    });

</script>