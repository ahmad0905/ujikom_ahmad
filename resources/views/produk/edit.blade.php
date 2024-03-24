<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="produk_id">

                <div class="form-group">
                    <label for="name" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="nama">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                </div>
                

                <div class="form-group">
                    <label for="name" class="control-label">Deskripsi</label>
                    <input type="text" class="form-control" id="deskripsi">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-deskripsi"></div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">Image</label>
                    <input type="file" class="form-control" id="image">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-image"></div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">Harga</label>
                    <input type="integer" class="form-control" id="harga">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-harga"></div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">Stok</label>
                    <input type="integer" class="form-control" id="stok">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-stok"></div>
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
    //button create produk event
    $('body').on('click', '#btn-edit-produk', function () {

        let produk_id = $(this).data('id');

        //fetch detail produk with ajax
        $.ajax({
            url: `/produks/${produk_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#produk_id').val(response.data.id);
                $('#nama-edit').val(response.data.nama);
                $('#deskripsi-edit').val(response.data.deskripsi);
                $('#image-edit').val(response.data.image);
                $('#harga-edit').val(response.data.harga);
                $('#stok-edit').val(response.data.stok);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update produk
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let produk_id = $('#produk_id').val();
        let nama = $('#nama-edit').val();
        let deskripsi = $('#deskripsi-edit').val();
        let image = $('#image-edit').val();
        let harga = $('#harga-edit').val();
        let stok = $('#stok-edit').val();

        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `/produks/${produk_id}`,
            type: "GET",
            cache: false,
            data: {
                "nama": nama,
                "deskripsi": deskripsi,
                "image": image,
                "harga": harga,
                "stok": stok,
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

                //data produk
                let produk = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.nama}</td>
                        <td>${response.data.deskripsi}</td>
                        <td>${response.data.image}</td>
                        <td>${response.data.harga}</td>
                        <td>${response.data.stok}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-produk" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-produk" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;
                
                //append to produk data
                $(`#index_${response.data.id}`).replaceWith(produk);

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

                if(error.responseJSON.deskripsi[0]) {

                    //show alert
                    $('#alert-deskripsi-edit').removeClass('d-none');
                    $('#alert-deskripsi-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-deskripsi-edit').html(error.responseJSON.deskripsi[0]);
                } 

                if(error.responseJSON.image[0]) {

                    //show alert
                    $('#alert-image-edit').removeClass('d-none');
                    $('#alert-image-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-image-edit').html(error.responseJSON.image[0]);
                } 

                if(error.responseJSON.harga[0]) {

                    //show alert
                    $('#alert-harga-edit').removeClass('d-none');
                    $('#alert-harga-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-harga-edit').html(error.responseJSON.harga[0]);
                }
                
                if(error.responseJSON.stok[0]) {

                    //show alert
                    $('#alert-stok-edit').removeClass('d-none');
                    $('#alert-stok-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-stok-edit').html(error.responseJSON.stok[0]);
                } 


            }

        });

    });

</script>




<script>
    //button create produk event
    $('body').on('click', '#btn-delete-produk', function () {

        let produk_id = $(this).data('id');
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

                    url: `/produks/${produk_id}`,
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

                        //remove produk on table
                        $(`#index_${produk_id}`).remove();
                    }
                });

                
            }
        })
        
    });
</script>