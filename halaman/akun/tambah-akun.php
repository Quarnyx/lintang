<form id="tambah-akun" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Nama akun</label>
                <input type="text" class="form-control" name="nama_akun" placeholder="Nama Akun">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Tipe Akun</label>
                <select name="kategori_akun" class="form-select">
                    <?php
                    require_once '../../config.php';
                    $query = mysqli_query($conn, "SHOW COLUMNS FROM akun LIKE 'kategori_akun'");
                    $enum = explode("','", substr(mysqli_fetch_array($query)['Type'], 6, -2));
                    foreach ($enum as $key => $value) {
                        echo "<option value='$value'>$value</option>";
                    }

                    ?>
                </select>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Kode akun</label>
                <input type="text" name="kode_akun" class="form-control" placeholder="Kode akun">
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
    $("#tambah-akun").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'aksi.php?aksi=tambah-akun',
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