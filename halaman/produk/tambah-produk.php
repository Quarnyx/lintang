<form id="tambah-barang" enctype="multipart/form-data">
    <?php
    require_once '../../config.php';
    $query = mysqli_query($conn, "SELECT MAX(kode_produk) AS kode_produk FROM produk");
    $data = mysqli_fetch_array($query);
    $max = $data['kode_produk'] ? substr($data['kode_produk'], 4, 3) : "000";
    $no = $max + 1;
    $char = "PRD-";
    $kode = $char . sprintf("%03s", $no);
    ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Kode Produk</label>
                <input type="text" name="kode_produk" class="form-control" placeholder="Kode Produk"
                    value="<?= $kode ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" class="form-control" name="nama_produk" placeholder="Produk">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Harga Beli</label>
                <input type="number" name="harga_beli" class="form-control" placeholder="Harga Beli">
            </div>
            <div class="mb-3">
                <label class="form-label">Satuan Produk</label>
                <input type="text" name="satuan" class="form-control" placeholder="Satuan">
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
            <div class="mb-3">
                <label class="form-label">Supplier</label>
                <select name="id_supplier" class="form-select">
                    <option value="">Pilih Supplier</option>
                    <?php
                    include '../../config.php';
                    $data = $conn->query("SELECT * FROM supplier");
                    while ($d = $data->fetch_array()) {
                        ?>
                        <option value="<?= $d['id'] ?>"><?= $d['nama_supplier'] ?></option>
                        <?php
                    }
                    ?>
                </select>
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