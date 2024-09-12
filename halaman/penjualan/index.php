<?php
$sub_title = "Penjualan Produk";
$title = "Kasir";
include 'partials/page-title.php'; ?>


<!-- end row-->
<?php
require_once 'config.php';
$query = mysqli_query($conn, "SELECT MAX(kode_penjualan) AS kode_penjualan FROM penjualan");
$data = mysqli_fetch_array($query);
$max = $data['kode_penjualan'] ? substr($data['kode_penjualan'], 4, 3) : "000";
$no = $max + 1;
$char = "INV-";
$kode = $char . sprintf("%03s", $no);
?>
<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Kode Penjualan</h4>
                <h2><?php echo $kode ?></h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form id="keranjang" enctype="multipart/form-data">
                    <input type="hidden" name="kode_penjualan" value="<?= $kode ?>">
                    <input type="hidden" name="id_pengguna" value="<?= $_SESSION['id'] ?>">
                    <div class="mb-3">
                        <label for="simpleinput" class="form-label">Pelanggan</label>
                        <select class="form-control select2" id="pelanggan" name="id_pelanggan" data-toggle="select2">
                            <option value="">Pilih Pelanggan</option>
                            <?php
                            $sql = "SELECT * FROM pelanggan";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) { ?>

                                <option value="<?= $row['id'] ?>" data-alamat="<?= $row['alamat'] ?>">
                                    <?= $row['nama_pelanggan'] ?>
                                </option>
                                <?php
                            }

                            ?>
                        </select>
                    </div>
                    <div class=" mb-3">
                        <label for="simpleinput" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" id="" cols="10" rows="3" readonly></textarea>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Produk</label>
                                <select class="form-select select2" data-toggle="select2" id="barang" name="id_produk">
                                    <option value="">Pilih Produk</option>
                                    <?php
                                    require_once 'config.php';
                                    $sql = "SELECT * FROM stok";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value="<?= $row['id'] ?>" data-hargabeli="<?= $row['harga_beli'] ?>"
                                            data-hargajual="<?= $row['harga_jual'] ?>"><?= $row['nama_produk'] ?> - Stok
                                            <?= $row['stok'] ?>
                                        </option>
                                        <?php
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Harga Jual</label>
                                <input type="number" name="harga_jual" class="form-control" placeholder="Harga Jual">
                                <input type="hidden" name="harga_beli">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Qty</label>
                                <input type="number" name="qty" class="form-control" placeholder="Qty">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success rounded-pill waves-effect waves-light mb-3"><i
                                    class="mdi mdi-plus"></i> Tambah Barang</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-6">
        <div id="load-table"></div>

    </div>
</div>



<script>
    function loadTable() {
        var kode_penjualan = "<?php echo $kode; ?>";
        $('#load-table').load('halaman/penjualan/tabel-penjualan.php', { kode_penjualan: kode_penjualan })
    }
    $(document).ready(function () {
        $('.select2').select2({
        })
        $('#pelanggan').on('change', function () {
            var alamat = $(this).find(':selected').data('alamat');
            $('textarea[name=alamat]').val(alamat);
        });
        loadTable();
        $('#barang').on('change', function () {
            var hargabeli = $(this).find(':selected').data('hargabeli');
            var hargajual = $(this).find(':selected').data('hargajual');
            $('input[name=harga_beli]').val(hargabeli);
            $('input[name=harga_jual]').val(hargajual);
        });

        $("#keranjang").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'aksi.php?aksi=keranjang',
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
    });
</script>