<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH PENJUALAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="control-label">Tanggal Penjualanan</label>
                    <input type="date" class="form-control" id="tanggal_penjualanan">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal_penjualanan"></div>
                </div>
                

                <div class="form-group">
                    <label for="name" class="control-label">Total Harga</label>
                    <input type="number" class="form-control" id="total_harga">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-total_harga"></div>
                </div>

                <div class="form-group">
                    <label for="id_user">Nama user</label>
                    <select class="form-control" id="id_user" name="id_user">
                        <option value="">Pilih user</option>
                        
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-id_user"></div>
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
    //button create penjualan event
    $('body').on('click', '#btn-create-penjualan', function () {

        //open modal
        $('#modal-create').modal('show');
    });

    //action create post
    $('#store').click(function(e) {
        e.preventDefault();

        //define variable
        let tanggal_penjualan   = $('#tanggal_penjualan').val();
        let total_harga = $('#total_harga').val();
        let id_user = $('#id_user').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `/penjualans`,
            type: "POST",
            cache: false,
            data: {
                "tanggal_penjualan": tanggal_penjualan,
                "total_harga": total_harga,
                "id_user": id_user,
                "_token": token
            },
            success:function(response){

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    tanggal_penjualan: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                //data post
                let penjualan = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.tanggal_penjualan}</td>
                        <td>${response.data.total_harga}</td>
                        <td>${response.data.id_user}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-penjualan" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-penjualan" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;
                
                //append to table
                $('#table-penjualans').prepend(penjualan);
                
                //clear form
                $('#tanggal_penjualan').val('');
                $('#total_harga').val('');
                $('#id_user').val('');
                

                //close modal
                $('#modal-create').modal('hide');
                

            },
            error:function(error){
                
                if(error.responseJSON.tanggal_penjualan[0]) {

                    //show alert
                    $('#alert-tanggal_penjualan').removeClass('d-none');
                    $('#alert-tanggal_penjualan').addClass('d-block');

                    //add message to alert
                    $('#alert-tanggal_penjualan').html(error.responseJSON.tanggal_penjualan[0]);
                } 

                if(error.responseJSON.total_harga[0]) {

                    //show alert
                    $('#alert-total_harga').removeClass('d-none');
                    $('#alert-total_harga').addClass('d-block');

                    //add message to alert
                    $('#alert-total_harga').html(error.responseJSON.total_harga[0]);
                } 

                if(error.responseJSON.id_user[0]) {

                    //show alert
                    $('#alert-id_user').removeClass('d-none');
                    $('#alert-id_user').addClass('d-block');

                    //add message to alert
                    $('#alert-id_user').html(error.responseJSON.id_user[0]);
                } 

                
            }

    });

});
</script>