<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Penjualan</h4>
                <table id="tabel-data" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Kode Penjualan</th>
                            <th>Tanggal Transaksi</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        session_start();
                        include "../../config.php";
                        $query = mysqli_query($conn, "SELECT * FROM penjualan");
                        while ($data = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?= $data['kode_penjualan'] ?></td>
                                <td><?= $data['tanggal_transaksi'] ?></td>
                                <td>Rp. <?= number_format($data['total'], 0, ',', '.') ?></td>
                                <td>
                                    <form action="" method="post" style="display: inline;">
                                        <input type="hidden" name="hapus-penjualan" value="<?= $data['id'] ?>">
                                        <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                        <input type="hidden" name="kode_penjualan" value="<?= $data['kode_penjualan'] ?>">
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                    <a href="halaman/penjualan/cetak-faktur.php?id=<?= $data['kode_penjualan'] ?>"
                                        target="_blank" class="btn btn-primary">Cetak</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->


<script>
    $(document).ready(function () {
        $('#tabel-data').DataTable();




    });
</script>