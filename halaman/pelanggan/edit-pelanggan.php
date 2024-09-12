<?php
require_once '../../config.php';
$sql = "SELECT * FROM pelanggan WHERE id = '$_POST[id]'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<form id="edit-pelanggan" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Nama Pelanggan</label>
                <input type="text" id="simpleinput" class="form-control" name="nama_pelanggan" placeholder="Pelanggan"
                    value="<?= $row['nama_pelanggan'] ?>">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Nomor HP</label>
                <input type="text" name="no_hp" class="form-control" placeholder="Nomor HP"
                    value="<?= $row['kontak'] ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="mb-3">
                <label for="" class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat_pelanggan" id="" cols="10"
                    rows="5"><?php echo $row['alamat'] ?></textarea>
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
    $("#edit-pelanggan").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'aksi.php?aksi=edit-pelanggan',
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