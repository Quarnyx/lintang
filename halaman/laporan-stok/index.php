<?php
$sub_title = "Laporan Stok";
$title = "Stok";
include 'partials/page-title.php'; ?>

<div class="row d-print-none">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Filter Tanggal</h5>
            </div><!-- end card header -->
            <?php
            function tanggal($tanggal)
            {
                $bulan = array(
                    1 => 'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
                $split = explode('-', $tanggal);
                return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
            }
            $daritanggal = "";
            $sampaitanggal = "";

            if (isset($_GET['dari_tanggal']) && isset($_GET['sampai_tanggal'])) {
                $daritanggal = $_GET['dari_tanggal'];
                $sampaitanggal = $_GET['sampai_tanggal'];
            }

            ?>
            <div class="card-body">
                <form action="" method="get" class="row g-3">
                    <input type="hidden" name="halaman" value="laporan-stok">
                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" id="validationDefault01" required=""
                            name="dari_tanggal">
                    </div>
                    <div class="col-md-6">
                        <label for="validationDefault02" class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" id="validationDefault02" required=""
                            name="sampai_tanggal">
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Pilih</button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div>
</div>
<!-- end row-->
<?php if (isset($_GET['dari_tanggal']) && isset($_GET['sampai_tanggal'])) { ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <h4 class="text-center mt-3 mb-3"><b>TOKO LINTANG</b><br><b>LAPORAN STOK BARANG</b><br>
                    <hr style="border: 1px solid black;">
                    Periode <?php
                    if (!empty($_GET["dari_tanggal"]) && !empty($_GET["sampai_tanggal"])) {
                        echo tanggal($_GET['dari_tanggal']) . " s.d " . tanggal($_GET['sampai_tanggal']);
                    } else {
                        echo "Semua";
                    }
                    ?>
                </h4>
                <div class="card-body">


                    <table id="tabel-data" class="table table-bordered table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="vertical-align: middle;">No</th>
                                <th class="text-center" style="vertical-align: middle;">Nama Barang</th>
                                <th class="text-center" style="vertical-align: middle;">Stok Masuk</th>
                                <th class="text-center" style="vertical-align: middle;">Stok Keluar</th>
                                <th class="text-center" style="vertical-align: middle;">Stok Akhir</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $kondisi = "";
                            $daritanggal = $_GET['dari_tanggal'];
                            $sampaitanggal = $_GET['sampai_tanggal'];
                            include "config.php";
                            $query = mysqli_query($conn, "SELECT * FROM produk");
                            while ($data = mysqli_fetch_array($query)) {
                                ?>
                                <tr>
                                    <td><?= ++$no ?></td>
                                    <td><?= $data['nama_produk'] ?></td>
                                    <td>
                                        <?php
                                        // stok masuk
                                        $initsqlin = "SELECT SUM(qty) AS qty FROM pembelian WHERE id_produk = '$data[id]' AND tanggal_transaksi BETWEEN '$daritanggal' AND '$sampaitanggal'";
                                        $initresultin = $conn->query($initsqlin);
                                        $initdatain = mysqli_fetch_array($initresultin);
                                        if ($initdatain['qty'] == null) {
                                            $initdatain['qty'] = 0;
                                        }
                                        echo $initdatain['qty'];
                                        ?>


                                    </td>
                                    <td>
                                        <?php
                                        // stok keluar
                                        $sqlout = "SELECT SUM(qty) AS qty FROM keranjang WHERE id_produk = '$data[id]' AND tanggal_transaksi BETWEEN '$daritanggal' AND '$sampaitanggal'";
                                        $resultout = $conn->query($sqlout);
                                        $dataout = mysqli_fetch_array($resultout);
                                        if ($dataout['qty'] == null) {
                                            $dataout['qty'] = 0;
                                        }
                                        echo $dataout['qty'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $initdatain['qty'] - $dataout['qty'];
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="mt-3" style="text-align:end;">
                        <hr>
                        <p class="font-weight-bold">Kendal, <?= tanggal(date('Y-m-d')) ?><br>Mengetahui,</p>
                        <div class="mt-5">
                            <p class="font-weight-bold">Pimpinan</p>
                        </div>
                    </div>
                    <div class="mt-4 mb-1">
                        <div class="text-end d-print-none">
                            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i
                                    class="mdi mdi-printer me-1"></i> Print</a>
                        </div>
                    </div>
                </div> <!-- end card body-->

            </div> <!-- end card -->

        </div><!-- end col-->
    </div>
    <!-- end row-->
<?php }
?>

<script>
</script>