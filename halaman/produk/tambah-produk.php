<form id="tambah-barang" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" class="form-control" name="nama_produk" placeholder="Produk">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Harga Beli</label>
                <input type="number" name="harga_beli" class="form-control" placeholder="Harga Beli">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Kategori Produk</label>
                <input type="text" name="kategori_produk" class="form-control" placeholder="Kategori">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Harga Jual</label>
                <input type="number" name="harga_jual" class="form-control" placeholder="Harga Jual">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Satuan Produk</label>
                <input type="text" name="satuan" class="form-control" placeholder="Satuan">
            </div>
        </div>
        </script>
    </div>

    <div class="row">
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>

<script>
    $("#tambah-barang").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'aksi.php?aksi=tambah-produk',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status == 'success') {
                    alertify.success(response.message);
                    $(".modal").modal('hide');
                    loadTable();
                } else {
                    alertify.error(response.message);
                }
            },
            error: function (data) {
                alertify.error(data);
            }
        });
    });
</script>