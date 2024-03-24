<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            <div class="form-group">
                <label for="id_produk">Produk</label>
                <select class="form-control" id="id_produk" name="id_produk">
                    <option value="">Pilih produk</option>
                    @foreach ($produks as $produk)
                        <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                        <label for="id_pembeli">pembeli</label>
                        <select class="form-control" id="id_pembeli" name="id_pembeli">
                            <option value="">Pilih pembeli</option>
                            @foreach($pembelis as $pembeli)
                                <option value="{{ $pembeli->id }}">{{ $pembeli->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_kasir">Kasir</label>
                        <select class="form-control" id="id_kasir" name="id_kasir">
                            <option value="">Pilih Kasir</option>
                            @foreach($kasirs as $kasir)
                                <option value="{{ $kasir->id }}">{{ $kasir->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tgl">Tanggal</label>
                        <input type="date" class="form-control" id="tgl" name="tgl">
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah">
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
    //button create transaksi event
    $('body').on('click', '#btn-create-transaksi', function () {

        //open modal
        $('#modal-create').modal('show');
    });

    //action create transaksi
    $('#store').click(function(e) {
        e.preventDefault();

        //define variable
        let id_produk   = $('#id_produk').val();
        let id_pembeli   = $('#id_pembeli').val();
        let id_kasir = $('#id_kasir').val();
        let tgl = $('#tgl').val();
        let jumlah = $('#jumlah').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `/transaksi`,
            type: "POST",
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
                
                //append to table
                $('#table-transaksis').prepend(transaksi);
                
                //clear form
                $('#id_produk').val('');
                $('#id_pembeli').val('');
                $('#id_kasir').val('');
                $('#tgl').val('');
                $('#jumlah').val('');

                //close modal
                $('#modal-create').modal('hide');
                

            },
            // error:function(error){
                
            //     if(error.responseJSON.id_produk[0]) {

            //         //show alert
            //         $('#alert-id_produk').removeClass('d-none');
            //         $('#alert-id_produk').addClass('d-block');

            //         //add message to alert
            //         $('#alert-id_produk').html(error.responseJSON.id_produk[0]);
            //     } 

            //     if(error.responseJSON.id_pembeli[0]) {

            //         //show alert
            //         $('#alert-id_pembeli').removeClass('d-none');
            //         $('#alert-id_pembeli').addClass('d-block');

            //         //add message to alert
            //         $('#alert-id_pembeli').html(error.responseJSON.id_pembeli[0]);
            //     } 

            //     if(error.responseJSON.id_kasir[0]) {

            //         //show alert
            //         $('#alert-id_kasir').removeClass('d-none');
            //         $('#alert-id_kasir').addClass('d-block');

            //         //add message to alert
            //         $('#alert-id_kasir').html(error.responseJSON.id_kasir[0]);
            //     } 

            //     if(error.responseJSON.jumlah[0]) {

            //         //show alert
            //         $('#alert-jumlah').removeClass('d-none');
            //         $('#alert-jumlah').addClass('d-block');

            //         //add message to alert
            //         $('#alert-jumlah').html(error.responseJSON.jumlah[0]);
            //     } 

            // }

        });

    });

</script>