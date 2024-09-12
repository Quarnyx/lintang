<form id="tambah-transaksi" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-3">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Tanggal Transaski</label>
                <input type="date" class="form-control" name="tanggal_transaksi">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Jenis Transaski</label>
                <select class="form-select" name="jenis_transaksi">
                    <option value="Pendapatan">Pendapatan</option>
                    <option value="Pengeluaran">Pengeluaran</option>
                </select>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Jumlah Transaksi</label>
                <input type="number" name="total" class="form-control" placeholder="Jumlah Transaksi">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Akun Debit</label>
                <select class="form-select" name="id_akun_debit">
                    <?php
                    require_once '../../config.php';

                    $sql = "SELECT * FROM akun";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['nama_akun'] . '</option>';
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Akun Kredit</label>
                <select class="form-select" name="id_akun_kredit">
                    <?php
                    require_once '../../config.php';

                    $sql = "SELECT * FROM akun";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['nama_akun'] . '</option>';
                    }

                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="mb-3">
                <label for="" class="form-label">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" id="" cols="10" rows="5"></textarea>
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
    $("#tambah-transaksi").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'aksi.php?aksi=tambah-transaksi',
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
                } if (response.status == 'error') {
                    alertify.error(response.message);
                }
            },
            error: function (data) {
                alertify.error('Gagal');
            }
        });
    });
</script>