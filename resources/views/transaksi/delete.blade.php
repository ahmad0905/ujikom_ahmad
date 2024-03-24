<script>
    //button create transaksi event
    $('body').on('click', '#btn-delete-transaksi', function () {

        let transaksi_id = $(this).data('id');
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

                    url: `/transaksi/${transaksi_id}`,
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

                        //remove transaksi on table
                        $(`#index_${transaksi_id}`).remove();
                    }
                });

                
            }
        })
        
    });
</script>