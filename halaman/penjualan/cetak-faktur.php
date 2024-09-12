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
    $query = mysqli_query($conn, "SELECT * FROM view_keranjang WHERE kode_penjualan = '$_GET[id]'");
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
                                <h3><b>Faktur <?= $inv['kode_penjualan'] ?></b></h3>
                                <p><strong>Alamat : </strong> Jln. Medoho Rt 05 Rw 09 Kelurahan Gayamsari Kecamatan
                                    Sambirejo Kota Semarang.</p>
                                <p><strong>Tanggal Cetak : </strong> <span class="">
                                        <?= date('d F Y'); ?></span></p>
                            </div><!-- end col -->
                            <div class="col-md-4">
                                <div class="float-end">

                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mt-4 table-centered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Item</th>
                                                <th style="width: 20%">Harga</th>
                                                <th style="width: 10%">QTY</th>
                                                <th style="width: 20%" class="text-end">Total</th>
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
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $data['nama_produk'] ?></td>
                                                    <td>Rp. <?= number_format($data['harga_jual'], 0, ',', '.') ?></td>
                                                    <td><?= $data['qty'] ?></td>
                                                    <td class="text-end">Rp.
                                                        <?= number_format($data['harga_jual'] * $data['qty'], 0, ',', '.') ?>
                                                    </td>

                                                </tr>
                                                <?php
                                                $harga_beli += $data['harga_beli'] * $data['qty'];
                                                $harga_jual += $data['harga_jual'] * $data['qty'];
                                                $total += ($data['harga_jual'] * $data['qty']);
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="clearfix pt-5">
                                </div>
                            </div> <!-- end col -->
                            <div class="col-sm-6">
                                <div class="float-end">
                                    <h3>Total : Rp. <?= number_format($total, 0, ',', '.') ?></h3>
                                </div>
                                <div class="clearfix"></div>
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