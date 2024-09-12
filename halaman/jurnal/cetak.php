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
    function bulan($inputbulan)
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
        return $bulan[(int) $inputbulan[1]];
    }
    $query = mysqli_query($conn, "SELECT * FROM jurnal WHERE MONTH(tanggal_transaksi) = '$_GET[bulan]' ORDER BY id_transaksi DESC");
    $inv = mysqli_fetch_array($query);
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
                                <h3><b>NERACA</b></h3>
                                <p><strong>Alamat : </strong> Jln. Medoho Rt 05 Rw 09 Kelurahan Gayamsari Kecamatan
                                    Sambirejo Kota Semarang.</p>
                                <p><strong>Tanggal Cetak : </strong> <span class="">
                                        <?= date('d F Y'); ?></span></p>
                                <p><strong>Periode Bulan : <?= bulan($_GET['bulan']) ?> </strong> <span class="">
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
                                            $total = 0;
                                            $harga_beli = 0;
                                            $harga_jual = 0;
                                            $no = 1;
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
                                            }
                                            ?>

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
    ?>

</body>
<script>

    window.print();
    window.onafterprint = window.close;
</script>

</html>