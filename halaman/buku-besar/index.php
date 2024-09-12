<?php
$sub_title = "Laporan Buku Besar";
$title = "Laporan Buku Besar";
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
                    <input type="hidden" name="halaman" value="buku-besar">
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
<style>
    th,
    td {
        padding: 10px;
        text-align: left;
        /* Mengatur teks ke kiri */
    }

    .right-align {
        float: right;
        /* Mengatur nominal ke kanan */
    }

    .clear {
        clear: both;
    }

    .small-text {
        font-size: 12px;
        color: gray;
    }
</style>
<?php
require_once 'config.php';
if (isset($_GET['dari_tanggal']) && isset($_GET['sampai_tanggal'])) {
    $daribulan = $_GET['dari_tanggal'];
    $sampaibulan = $_GET['sampai_tanggal'];
    $date = DateTime::createFromFormat('Y-m-d', $sampaibulan);
    $year = $date->format('Y');
    $kondisi = "WHERE tanggal_transaksi BETWEEN '$daribulan' AND '$sampaibulan'";

} else {
    $kondisi = "";
}

?>
<div class="row">
    <div class="col-12">
        <div class="card align-items-center text-align-center">
            <?php
            include 'config.php';
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Query untuk mendapatkan data dari view buku besar
            $sql = "SELECT nama_akun, debit AS debit, kredit AS kredit, tanggal_transaksi FROM jurnal $kondisi  ORDER BY nama_akun, id_transaksi";
            $result = $conn->query($sql);

            // Inisialisasi array untuk menyimpan data berdasarkan nama akun
            $accounts = [];
            $total_debit = 0;
            $total_kredit = 0;

            if ($result->num_rows > 0) {
                // Loop hasil query dan masukkan ke array per akun
                while ($row = $result->fetch_assoc()) {
                    $accounts[$row['nama_akun']][] = $row;
                }
            }
            ?>
            <h4 class="text-center mt-3 mb-3"><b>TOKO LINTANG</b><br><b>LAPORAN BUKU BESAR</b>
                <hr class="text-center mb-3">
                <br>Periode <?php
                if (!empty($_GET["dari_tanggal"]) && !empty($_GET["sampai_tanggal"])) {
                    echo tanggal($_GET['dari_tanggal']) . " - " . tanggal($_GET['sampai_tanggal']);
                } else {
                    echo "Semua";
                }
                ?>
            </h4>

            <?php
            // Loop setiap akun dan tampilkan dalam bentuk T
            foreach ($accounts as $nama_akun => $transactions) {
                // Inisialisasi total debit dan kredit
                $total_debit = 0;
                $total_kredit = 0;

                echo "<div class='table-responsive'>";
                echo "<div class='text-center'><h5>Akun: " . $nama_akun . "</h5></div>";
                echo "<table class='table table-bordered' style='width: 550px;'>";
                echo "<tr><th class='text-center w-50'>Debit</th><th class='text-center w-50'>Kredit</th></tr>";

                // Loop transaksi per akun
                foreach ($transactions as $transaction) {
                    echo "<tr>";

                    // Debit
                    echo "<td>";
                    if ($transaction['debit'] > 0) {
                        // Tanggal di kiri, nominal Rp di kanan
                        echo "<span class='small-text'>" . date('d-m-Y', strtotime($transaction['tanggal_transaksi'])) . "</span>";
                        echo "<span class='right-align'>" . 'Rp ' . number_format($transaction['debit'], 2, ',', '.') . "</span>";
                        // Tambahkan ke total debit
                        $total_debit += $transaction['debit'];
                    }
                    echo "</td>";

                    // Kredit
                    echo "<td>";
                    if ($transaction['kredit'] > 0) {
                        // Tanggal di kiri, nominal Rp di kanan
                        echo "<span class='small-text'>" . date('d-m-Y', strtotime($transaction['tanggal_transaksi'])) . "</span>";
                        echo "<span class='right-align'>" . 'Rp ' . number_format($transaction['kredit'], 2, ',', '.') . "</span>";
                        // Tambahkan ke total kredit
                        $total_kredit += $transaction['kredit'];
                    }
                    echo "</td>";

                    echo "</tr>";
                }

                // Hitung selisih debit - kredit
                $saldo = $total_debit - $total_kredit;

                // Tampilkan total debit, total kredit, dan saldo
                echo "<tr class='bold'>";
                echo "<td>Total Debit: <span class='right-align'>" . 'Rp ' . number_format($total_debit, 2, ',', '.') . "</span></td>";
                echo "<td>Total Kredit: <span class='right-align'>" . 'Rp ' . number_format($total_kredit, 2, ',', '.') . "</span></td>";
                echo "</tr>";
                echo "<tr class='bold'>";
                echo "<td colspan='2'>Saldo (Debit - Kredit): <span class='right-align'>" . 'Rp ' . number_format($saldo, 2, ',', '.') . "</span></td>";
                echo "</tr>";

                echo "</table>";
                echo "<div class='clear'></div>";
                echo "</div>";
            }
            ?>


            <?php
            // Tutup koneksi
            $conn->close();
            ?>

        </div>
        <div class="mt-4 mb-1">
            <div class="text-end d-print-none">
                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i
                        class="mdi mdi-printer me-1"></i> Print</a>
            </div>
        </div>
    </div>

</div>
<!-- end row-->


<script>
</script>