<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT KASIR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="kasir_id">

                <div class="form-group">
                    <label for="name" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="nama-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama-edit"></div>
                </div>
                

                <div class="form-group">
                    <label class="control-label">Alamat</label>
                    <textarea class="form-control" id="alamat-edit" rows="4"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat-edit"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">telp</label>
                    <input type="integer" class="form-control" id="telp-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-telp-edit"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="string" class="form-control" id="email-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email-edit"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="update">UPDATE</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create kasir event
    $('body').on('click', '#btn-edit-kasir', function () {

        let kasir_id = $(this).data('id');

        //fetch detail kasir with ajax
        $.ajax({
            url: `/kasirs/${kasir_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#kasir_id').val(response.data.id);
                $('#nama-edit').val(response.data.nama);
                $('#alamat-edit').val(response.data.alamat);
                $('#telp-edit').val(response.data.telp);
                $('#email-edit').val(response.data.email);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update kasir
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let kasir_id = $('#kasir_id').val();
        let nama = $('#nama-edit').val();
        let alamat = $('#alamat-edit').val();
        let telp = $('#telp-edit').val();
        let email = $('#email-edit').val();

        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `/kasirs/${kasir_id}`,
            type: "GET",
            cache: false,
            data: {
                "nama": nama,
                "alamat": alamat,
                "telp": telp,
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

                //data kasir
                let kasir = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.nama}</td>
                        <td>${response.data.alamat}</td>
                        <td>${response.data.telp}</td>
                        <td>${response.data.email}</td>

                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-kasir" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-kasir" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;
                
                //append to kasir data
                $(`#index_${response.data.id}`).replaceWith(kasir);

                //close modal
                $('#modal-edit').modal('hide');
                

            },
            error:function(error){
                
                if(error.responseJSON.nama[0]) {

                    //show alert
                    $('#alert-nama-edit').removeClass('d-none');
                    $('#alert-nama-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-nama-edit').html(error.responseJSON.nama[0]);
                } 

                if(error.responseJSON.alamat[0]) {

                    //show alert
                    $('#alert-alamat-edit').removeClass('d-none');
                    $('#alert-alamat-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-alamat-edit').html(error.responseJSON.alamat[0]);
                } 

                if(error.responseJSON.telp[0]) {

                    //show alert
                    $('#alert-telp-edit').removeClass('d-none');
                    $('#alert-telp-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-telp-edit').html(error.responseJSON.telp[0]);
                } 

                if(error.responseJSON.email[0]) {

                    //show alert
                    $('#alert-email-edit').removeClass('d-none');
                    $('#alert-email-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-email-edit').html(error.responseJSON.email[0]);
                } 

            }

        });

    });

</script>




<script>
    //button create kasir event
    $('body').on('click', '#btn-delete-kasir', function () {

        let kasir_id = $(this).data('id');
        let token   = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "ingin menghapus data ini!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!'
        }).then((result) => {
            if (result.isConfirmed) {

                console.log('test');

                //fetch to delete data
                $.ajax({

                    url: `/kasirs/${kasir_id}`,
                    type: "DELETE",
                    cache: false,
                    data: {
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

                        //remove kasir on table
                        $(`#index_${kasir_id}`).remove();
                    }
                });

                
            }
        })
        
    });
</script>