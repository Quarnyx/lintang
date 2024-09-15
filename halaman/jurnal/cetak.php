<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Custom styles for this template -->
    <link href="../../assets/css/app.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />


</head>

<body>
    <?php
    include '../../config.php';
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Logo & title -->

                        <div class="row">
                            <div class="col-md-8">
                                <h3>TOKO LINTANG</h3>
                                <h3><b>LAPORAN JURNAL</b></h3>
                                <p><strong>Alamat : </strong> Jln. Medoho Rt 05 Rw 09 Kelurahan Gayamsari Kecamatan
                                    Sambirejo Kota Semarang.</p>
                                <p><strong>Tanggal Cetak : </strong> <span class="">
                                        <?= date('d F Y'); ?></span></p>
                                <p><strong>Periode Bulan : </strong> <span class="">
                                        <?= tanggal($daritanggal) . " s.d " . tanggal($sampaitanggal); ?> </strong>
                                        <span class="">
                            </div><!-- end col -->
                            <div class="col-md-4">
                                <div class="float-end">

                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->
                        <hr class="my-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mt-4 table-centered">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Deskripsi</th>
                                                <th>Akun</th>
                                                <th>Debit</th>
                                                <th>Kredit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "../../config.php";
                                            $debit = 0;
                                            $kredit = 0;
                                            $no = 1;

                                            $query = mysqli_query($conn, "SELECT * FROM jurnal WHERE tanggal_transaksi BETWEEN '$_GET[dari_tanggal]' AND '$_GET[sampai_tanggal]' ORDER BY id_transaksi DESC");

                                            while ($data = mysqli_fetch_array($query)) {
                                                ?>
                                                <tr>
                                                    <td><?= $data['tanggal_transaksi'] ?></td>
                                                    <td><?= $data['deskripsi'] ?></td>
                                                    <td><?= $data['nama_akun'] ?></td>
                                                    <td>Rp. <?= number_format($data['debit'], 0, ',', '.') ?></td>
                                                    <td>Rp. <?= number_format($data['kredit'], 0, ',', '.') ?></td>

                                                </tr>
                                                <?php

                                                $debit += $data['debit'];
                                                $kredit += $data['kredit'];
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="3">Total</td>
                                                <td>Rp. <?= number_format($debit, 0, ',', '.') ?></td>
                                                <td>Rp. <?= number_format($kredit, 0, ',', '.') ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->


                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>

    </div>




</body>
<script>

    window.print();
    window.onafterprint = window.close;
</script>

</html>