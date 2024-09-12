<?php
$sub_title = "Laporan Laba - Rugi";
$title = "Laporan Laba - Rugi";
include 'partials/page-title.php'; ?>

<div class="row d-print-none">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Periode Tanggal</h5>
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
                    <input type="hidden" name="halaman" value="laba-rugi">
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
    <?php
    require_once 'config.php';
    if (isset($_GET['dari-tanggal']) && isset($_GET['sampai-tanggal'])) {
        $daribulan = $_GET['dari-tanggal'];
        $sampaibulan = $_GET['sampai-tanggal'];
        $date = DateTime::createFromFormat('Y-m-d', $sampaibulan);
        $year = $date->format('Y');
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
            return $bulan[(int) $split[1]];
        }
    }

    if (!isset($_GET['dari-tanggal']) && !isset($_GET['sampai-tanggal'])) {
        $kondisi = "";
    } else {
        $kondisi = "AND tanggal_transaksi BETWEEN '$daribulan' AND '$sampaibulan'";
    }
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <h4 class="text-center mt-3 mb-3"><b>TOKO LINTANG</b><br><b>LAPORAN LABA RUGI</b>
                    <hr class="text-center mb-3">
                    <br>Periode <?php
                    if (!empty($_GET["dari_tanggal"]) && !empty($_GET["sampai_tanggal"])) {
                        echo tanggal($_GET['dari_tanggal']) . " - " . tanggal($_GET['sampai_tanggal']);
                    } else {
                        echo "Semua";
                    }
                    ?>
                </h4>
                <div class="card-body">


                    <table class="table">
                        <tr>
                            <th>Pendapatan</th>
                        </tr>
                        <?php
                        $sqlaktiva = "SELECT SUM(kredit) - SUM(debit) AS kredit,
                                                                        jurnal.kategori_akun,
                                                                        jurnal.nama_akun
                                                                    FROM
                                                                        jurnal
                                                                    WHERE
                                                                        kategori_akun = 'Pendapatan' $kondisi
                                                                    GROUP BY
                                                                        jurnal.nama_akun";
                        $totalkredit = 0;
                        $aktivalancar = $conn->query($sqlaktiva);
                        while ($row = $aktivalancar->fetch_array()) {
                            ?>
                            <tr>
                                <td style="padding:0px 0px 0px 15px !important">
                                    <?php echo $row['nama_akun'] ?>
                                </td>
                                <td style="padding:0px !important" class="text-end">Rp
                                    <?php echo number_format($row['kredit'], 0, ',', '.');
                                    $totalkredit += $row['kredit'];
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php
                        $sqlaktiva = "SELECT SUM(debit) - SUM(kredit) AS kredit,
                                                                        jurnal.kategori_akun,
                                                                        jurnal.nama_akun
                                                                    FROM
                                                                        jurnal
                                                                    WHERE
                                                                        kategori_akun = 'Harga Pokok Penjualan' $kondisi
                                                                    GROUP BY
                                                                        jurnal.nama_akun";
                        $totalhpp = 0;
                        $aktivalancar = $conn->query($sqlaktiva);
                        while ($row = $aktivalancar->fetch_array()) {
                            ?>
                            <tr>
                                <td style="padding:0px 0px 0px 15px !important">
                                    <?php echo $row['nama_akun'] ?>
                                </td>
                                <td style="padding:0px !important" class="text-end">Rp
                                    <?php echo number_format($row['kredit'], 0, ',', '.');
                                    $totalhpp += $row['kredit'];
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td style="padding:0px 0px 0px 15px !important">Laba Kotor</td>
                            <td style="padding:0px !important" class="text-end">Rp
                                <?php echo number_format($labakotor = $totalkredit - $totalhpp, 0, ',', '.') ?>
                            </td>
                        <tr>
                            <th>Beban</th>
                        </tr>
                        <?php
                        $sqlaktiva = "SELECT
                                                                        SUM(debit) - SUM(kredit) AS debit,
                                                                        jurnal.kategori_akun,
                                                                        jurnal.nama_akun
                                                                    FROM jurnal
                                                                    WHERE kategori_akun = 'Beban' $kondisi
                                                                    GROUP BY
                                                                        jurnal.nama_akun";
                        $totalbeban = 0;
                        $aktivalancar = $conn->query($sqlaktiva);
                        while ($row = $aktivalancar->fetch_array()) {
                            ?>
                            <tr>
                                <td style="padding:0px 0px 0px 15px !important">
                                    <?php echo $row['nama_akun'] ?>
                                </td>
                                <td style="padding:0px !important" class="text-end">Rp
                                    <?php echo number_format($row['debit'], 0, ',', '.');
                                    $totalbeban += $row['debit']; ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td style="padding:0px 0px 0px 15px !important">Total Beban</td>
                            <td style="padding:0px !important" class="text-end">Rp
                                <?php echo number_format($totalbeban, 0, ',', '.') ?>
                            </td>
                        <tr>
                        <tr>
                            <td style="padding:0px 0px 0px 15px !important">Laba Bersih</td>
                            <?php
                            $totalwajib = $labakotor - $totalbeban;
                            ?>
                            <td style="padding:0px !important" class="text-end">Rp
                                <?php echo number_format($totalwajib, 0, ',', '.') ?>
                            </td>
                        </tr>

                    </table>
                    <div class="mt-3" style="text-align:end;">
                        <hr>
                        <p class="font-weight-bold">Kendal, <?= tanggal(date('Y-m-d')) ?><br>Mengetahui,</p>
                        <div class="mt-5">
                            <p class="font-weight-bold"><?php echo $_SESSION['nama']; ?></p>
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