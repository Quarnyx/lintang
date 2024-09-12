<?php
session_start();
require_once '../../config.php';
$sql = "SELECT * FROM view_pembelian WHERE id = '$_POST[id]'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<form id="edit-pembelian" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row['id']; ?>">
    <input type="hidden" name="id_pengguna" value="<?= $_SESSION['id']; ?>">
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Tanggal Pembelian</label>
                <input type="date" class="form-control" name="tanggal_transaksi"
                    value="<?php echo $row['tanggal_transaksi'] ?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Kode Pembelian</label>
                <input type="text" name="kode_pembelian" class="form-control" placeholder="Jumlah Transaksi"
                    value="<?= $row['kode_pembelian'] ?>" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Barang</label>
                <select class="form-select" name="id_produk">
                    <?php
                    $sql = "SELECT * FROM produk";
                    $result = $conn->query($sql);
                    while ($rowa = $result->fetch_assoc()) {
                        echo '<option value="' . $rowa['id'] . '"' . ($rowa['id'] == $row['id_produk'] ? 'selected' : '') . '>' . $rowa['nama_produk'] . '</option>';
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Supplier</label>
                <select class="form-select" name="id_supplier">
                    <?php
                    $sql = "SELECT * FROM supplier";
                    $result = $conn->query($sql);
                    while ($rowb = $result->fetch_assoc()) {
                        echo '<option value="' . $rowb['id'] . '"' . ($rowb['id_supplier'] == $row['id_supplier'] ? 'selected' : '') . '>' . $rowb['nama_supplier'] . '</option>';
                    }

                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Harga Beli</label>
                <input type="number" class="form-control" name="harga_beli" value="<?= $row['harga_beli'] ?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Jumlah Beli</label>
                <input type="number" class="form-control" name="qty" value="<?= $row['qty'] ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Masuk ke</label>
                <select class="form-select" name="akun_debit">
                    <?php
                    require_once '../../config.php';

                    $sql = "SELECT * FROM akun";
                    $result = $conn->query($sql);
                    while ($rowc = $result->fetch_assoc()) {
                        echo '<option value="' . $rowc['id'] . '"' . ($rowc['id'] == $row['akun_debit'] ? 'selected' : '') . '>' . $rowc['nama_akun'] . '</option>';
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Dibayar dengan</label>
                <select class="form-select" name="akun_kredit">
                    <?php
                    require_once '../../config.php';

                    $sql = "SELECT * FROM akun";
                    $result = $conn->query($sql);
                    while ($rowd = $result->fetch_assoc()) {
                        echo '<option value="' . $rowd['id'] . '"' . ($rowd['id'] == $row['akun_kredit'] ? 'selected' : '') . '>' . $rowd['nama_akun'] . '</option>';
                    }

                    ?>
                </select>
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
    $("#edit-pembelian").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'aksi.php?aksi=edit-pembelian',
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