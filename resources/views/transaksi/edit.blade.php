<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="transaksi_id">

                <div class="form-group">
                <label for="id_produk-edit">Produk</label>
                <select class="form-control" id="id_produk-edit" name="id_produk-edit">
                    <option value="">Pilih produk</option>
                    @foreach ($produks as $produk)
                        <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                        <label for="id_pembeli-edit">pembeli</label>
                        <select class="form-control" id="id_pembeli-edit" name="id_pembeli-edit">
                            <option value="">Pilih pembeli</option>
                            @foreach($pembelis as $pembeli)
                                <option value="{{ $pembeli->id }}">{{ $pembeli->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_kasir-edit">Kasir</label>
                        <select class="form-control" id="id_kasir-edit" name="id_kasir-edit">
                            <option value="">Pilih Kasir</option>
                            @foreach($kasirs as $kasir)
                                <option value="{{ $kasir->id }}">{{ $kasir->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tgl-edit">Tanggal</label>
                        <input type="date" class="form-control" id="tgl-edit" name="tgl-edit">
                    </div>

                    <div class="form-group">
                        <label for="jumlah-edit">Jumlah-edit</label>
                        <input type="number" class="form-control" id="jumlah-edit" name="jumlah-edit">
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
    //button create transaksi event
    $('body').on('click', '#btn-edit-transaksi', function () {

        let transaksi_id = $(this).data('id');

        //fetch detail transaksi with ajax
        $.ajax({
            url: `/transaksi/${transaksi_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#transaksi_id').val(response.data.id);
                $('#id_produk-edit').val(response.data.id_produk);
                $('#id_pembeli-edit').val(response.data.id_pembeli);
                $('#id_kasir-edit').val(response.data.id_kasir);
                $('#tgl-edit').val(response.data.tgl);
                $('#jumlah-edit').val(response.data.jumlah);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update transaksi
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let transaksi_id = $('#transaksi_id').val();
        let id_produk   = $('#id_produk-edit').val();
        let id_pembeli   = $('#id_pembeli-edit').val();
        let id_kasir   = $('#id_kasir-edit').val();
        let tgl   = $('#tgl-edit').val();
        let jumlah = $('#jumlah-edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `/transaksi/${transaksi_id}`,
            type: "PUT",
            cache: false,
            data: {
                "id_produk": id_produk,
                "id_pembeli": id_pembeli,
                "id_kasir": id_kasir,
                "tgl": tgl,
                "jumlah": jumlah,
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

                //data transaksi
                let transaksi = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.id_produk}</td>
                        <td>${response.data.id_pembeli}</td>
                        <td>${response.data.id_kasir}</td>
                        <td>${response.data.tgl}</td>
                        <td>${response.data.jumlah}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-transaksi" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-transaksi" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;
                
                //append to transaksi data
                $(`#index_${response.data.id}`).replaceWith(transaksi);

                //close modal
                $('#modal-edit').modal('hide');
                

            },
            // error:function(error){
                
            //     if(error.responseJSON.title[0]) {

            //         //show alert
            //         $('#alert-title-edit').removeClass('d-none');
            //         $('#alert-title-edit').addClass('d-block');

            //         //add message to alert
            //         $('#alert-title-edit').html(error.responseJSON.title[0]);
            //     } 

            //     if(error.responseJSON.content[0]) {

            //         //show alert
            //         $('#alert-content-edit').removeClass('d-none');
            //         $('#alert-content-edit').addClass('d-block');

            //         //add message to alert
            //         $('#alert-content-edit').html(error.responseJSON.content[0]);
            //     } 

            // }

        });

    });

</script>