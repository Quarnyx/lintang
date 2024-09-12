<?php
require_once '../../config.php';
$sql = "SELECT * FROM produk WHERE id = '$_POST[id]'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>

<form id="edit-barang" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Nama barang</label>
                <input type="text" class="form-control" name="nama_produk" placeholder="Produk"
                    value="<?= $row['nama_produk'] ?>">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Harga Beli</label>
                <input type="number" name="harga_beli" class="form-control" placeholder="Harga Beli"
                    value="<?= $row['harga_beli'] ?>">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Kategori Produk</label>
                <input type="text" name="kategori_produk" value="<?= $row['kategori_produk'] ?>" class="form-control"
                    placeholder="Kategori">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Harga Jual</label>
                <input type="number" name="harga_jual" value="<?= $row['harga_jual'] ?>" class="form-control"
                    placeholder="Harga Jual">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Satuan Produk</label>
                <input type="text" name="satuan" value="<?= $row['satuan'] ?>" class="form-control"
                    placeholder="Satuan">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>

<script>
    $("#edit-barang").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'aksi.php?aksi=edit-produk',
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