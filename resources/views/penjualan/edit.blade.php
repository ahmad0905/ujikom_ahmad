<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT PENJUALAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="penjualan_id">

                <div class="form-group">
                    <label for="name" class="control-label">Tanggal Penjualan</label>
                    <input type="date" class="form-control" id="tanggal_penjualan-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal_penjualan-edit"></div>
                </div>
                

                <div class="form-group">
                    <label for="name" class="control-label">Total Harga</label>
                    <input type="text" class="form-control" id="total_harga">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-total_harga"></div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="id_pelanggan">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-id_pelanggan"></div>
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
    //button create penjualan event
    $('body').on('click', '#btn-edit-penjualan', function () {

        let penjualan_id = $(this).data('id');

        //fetch detail penjualan with ajax
        $.ajax({
            url: `/penjualans/${penjualan_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#penjualan_id').val(response.data.id);
                $('#tanggal_penjualan-edit').val(response.data.tanggal_penjualan);
                $('#total_harga-edit').val(response.data.total_harga);
                $('#id_pelanggan-edit').val(response.data.id_pelanggan);
                

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update penjualan
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let penjualan_id = $('#penjualan_id').val();
        let tanggal_penjualan = $('#tanggal_penjualan-edit').val();
        let total_harga = $('#total_harga-edit').val();
        let id_pelanggan = $('#id_pelanggan-edit').val();
       

        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `/penjualans/${penjualan_id}`,
            type: "GET",
            cache: false,
            data: {
                "tanggal_penjualan": tanggal_penjualan,
                "total_harga": total_harga,
                "id_pelanggan": id_pelanggan,
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

                //data penjualan
                let penjualan = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.tanggal_penjualan}</td>
                        <td>${response.data.total_harga}</td>
                        <td>${response.data.id_pelanggan}</td>
                        

                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-penjualan" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-penjualan" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;
                
                //append to penjualan data
                $(`#index_${response.data.id}`).replaceWith(penjualan);

                //close modal
                $('#modal-edit').modal('hide');
                

            },
            error:function(error){
                
                if(error.responseJSON.tanggal_penjualan[0]) {

                    //show alert
                    $('#alert-tanggal_penjualan-edit').removeClass('d-none');
                    $('#alert-tanggal_penjualan-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-tanggal_penjualan-edit').html(error.responseJSON.tanggal_penjualan[0]);
                } 

                if(error.responseJSON.total_harga[0]) {

                    //show alert
                    $('#alert-total_harga-edit').removeClass('d-none');
                    $('#alert-total_harga-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-total_harga-edit').html(error.responseJSON.total_harga[0]);
                }
                
                if(error.responseJSON.id_pelanggan[0]) {

                    //show alert
                    $('#alert-id_pelanggan').removeClass('d-none');
                    $('#alert-id_pelanggan').addClass('d-block');

                    //add message to alert
                    $('#alert-id_pelanggan').html(error.responseJSON.id_pelanggan[0]);
                } 

                

            }

        });

    });

</script>




<script>
    //button create penjualan event
    $('body').on('click', '#btn-delete-penjualan', function () {

        let penjualan_id = $(this).data('id');
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

                    url: `/penjualans/${penjualan_id}`,
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

                        //remove penjualan on table
                        $(`#index_${penjualan_id}`).remove();
                    }
                });

                
            }
        })
        
    });
</script>