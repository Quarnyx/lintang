<form id="tambah-pembelian" enctype="multipart/form-data">
    <?php
    session_start();
    ?>
    <input type="hidden" name="id_pengguna" value="<?= $_SESSION['id']; ?>">
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Tanggal Pembelian</label>
                <input type="date" class="form-control" name="tanggal_transaksi">
            </div>
        </div>
        <?php
        require_once '../../config.php';
        $query = mysqli_query($conn, "SELECT MAX(kode_pembelian) AS kode_pembelian FROM pembelian");
        $data = mysqli_fetch_array($query);
        $max = $data['kode_pembelian'] ? substr($data['kode_pembelian'], 4, 3) : "000";
        $no = $max + 1;
        $char = "PBL-";
        $kode = $char . sprintf("%03s", $no);
        ?>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Kode Pembelian</label>
                <input type="text" name="kode_pembelian" class="form-control" placeholder="Jumlah Transaksi"
                    value="<?= $kode; ?>" readonly>
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
                    while ($row = $result->fetch_assoc()) {
                        echo '<option data-price="' . $row['harga_beli'] . '" data-supplier="' . $row['id_supplier'] . '" value="' . $row['id'] . '">' . $row['nama_produk'] . '</option>';
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
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['nama_supplier'] . '</option>';
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
                <input type="number" class="form-control" name="harga_beli">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Jumlah Beli</label>
                <input type="number" class="form-control" name="qty">
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

                    $sql = "SELECT * FROM akun WHERE kategori_akun = 'Aktiva Lancar' OR kategori_akun = 'Aktiva Tetap'";
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
                <label class="form-label">Dibayar dengan</label>
                <select class="form-select" name="akun_kredit">
                    <?php
                    require_once '../../config.php';

                    $sql = "SELECT * FROM akun WHERE kategori_akun = 'Aktiva Lancar' OR kategori_akun = 'Aktiva Tetap'";
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
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('select[name="id_produk"]').on('change', function () {
            var price = $(this).find(':selected').data('price');
            var supplier = $(this).find(':selected').data('supplier');
            $('input[name="harga_beli"]').val(price);
            $('select[name="id_supplier"] option[value="' + supplier + '"]').prop('selected', true);
        });
    })
    $("#tambah-pembelian").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'aksi.php?aksi=tambah-pembelian',
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