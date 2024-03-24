<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            

            <div class="form-group">
                    <label for="name" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="nama">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                </div>
                

                <div class="form-group">
                    <label class="control-label">deskripsi</label>
                    <textarea class="form-control" id="deskripsi" rows="4"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-deskripsi"></div>
                </div>

                
                <div class="form-group">
                    <label for="name" class="control-label">harga</label>
                    <input type="number" class="form-control" id="harga">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-harga"></div>
                </div>
                
                <div class="form-group">
                    <label for="name" class="control-label">stok</label>
                    <input type="number" class="form-control" id="stok">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-stok"></div>
                </div>
                
                <div class="form-group">
                    <label for="name" class="control-label">image</label>
                    <input type="file" class="form-control" id="image">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-image"></div>
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
    //button create produk event
    $('body').on('click', '#btn-create-produk', function () {

        //open modal
        $('#modal-create').modal('show');
    });

    //action create produk
    $('#store').click(function(e) {
        e.preventDefault();

        //define variable
        
        let nama   = $('#nama').val();
        let deskripsi = $('#deskripsi').val();
        let harga = $('#harga').val();
        let stok = $('#stok').val();
        let image = $('#image')[0].files[0];
        let token   = $("meta[name='csrf-token']").attr("content");
        
        var formData = new FormData();
        
        formData.append('nama',nama);
        formData.append('deskripsi',deskripsi);
        formData.append('harga',harga);
        formData.append('stok', stok);
        formData.append('image', image);
        formData.append('_token',token);
        
        
        //ajax
        $.ajax({

            url: `/produks`,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            // data: {
            //     "nama": nama,
            //     "deskripsi": deskripsi,
            //     "image": image,
            //     "harga": harga,
            //     "stok": stok,
            //     "_token": token
            // },
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
                        <td>${response.data.harga}</td>
                        <td>${response.data.stok}</td>
                        <td>${response.data.image}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-produk" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-produk" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;
                
                //append to table
                $('#table-produks').prepend(produk);
                
                //clear form
                
                $('#nama').val('');
                $('#deskripsi').val('');
                $('#harga').val('');
                $('#stok').val('');
                $('#image').val('');


                //close modal
                $('#modal-create').modal('hide');
                

            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); // Tampilkan pesan kesalahan dalam konsol
            }
            // error:function(error){
                
            //     if(error.responseJSON.title[0]) {

            //         //show alert
            //         $('#alert-title').removeClass('d-none');
            //         $('#alert-title').addClass('d-block');

            //         //add message to alert
            //         $('#alert-title').html(error.responseJSON.title[0]);
            //     } 

            //     if(error.responseJSON.content[0]) {

            //         //show alert
            //         $('#alert-content').removeClass('d-none');
            //         $('#alert-content').addClass('d-block');

            //         //add message to alert
            //         $('#alert-content').html(error.responseJSON.content[0]);
            //     } 

            // }

        });

    });

</script>