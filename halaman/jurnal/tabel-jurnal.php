<table id="tabel-data" class="table table-bordered table-bordered dt-responsive nowrap">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Akun</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "../../config.php";
        if (isset($_GET['dari_tanggal']) && isset($_GET['sampai_tanggal'])) {
            $query = mysqli_query($conn, "SELECT * FROM jurnal WHERE tanggal_transaksi BETWEEN '$_GET[dari_tanggal]' AND '$_GET[sampai_tanggal]'  ORDER BY id_transaksi DESC");

        } else {
            $query = mysqli_query($conn, "SELECT * FROM jurnal ORDER BY id_transaksi DESC");

        }
        while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?= $data['tanggal_transaksi'] ?></td>
                <td><?= $data['deskripsi'] ?></td>
                <td><?= $data['nama_akun'] ?></td>
                <td>Rp. <?= number_format($data['debit'], 0, ',', '.') ?></td>
                <td>Rp. <?= number_format($data['kredit'], 0, ',', '.') ?></td>
                <td>
                    <button data-id="<?= $data['id_transaksi'] ?>" id="delete" type="button"
                        class="btn btn-danger">Delete</button>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<?php
require_once '../../config.php';
if (isset($_GET['dari_tanggal']) && isset($_GET['sampai_tanggal'])) {
    $sql = mysqli_query($conn, "SELECT sum(debit) AS debit FROM jurnal WHERE tanggal_transaksi BETWEEN '$_GET[dari_tanggal]' AND '$_GET[sampai_tanggal]'");
    $debit = mysqli_fetch_array($sql);
} else {
    $sql = mysqli_query($conn, "SELECT sum(debit) AS debit FROM jurnal");
    $debit = mysqli_fetch_array($sql);
}
if (!empty($debit['debit'])) {


    ?>

    <div class="row mt-5">
        <div class="=col-xxxl-3 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="justify-content-between">
                        <div class="row">
                            <div class="col-6">

                                <h4 class="text-success">
                                    <?php echo 'Rp ' . number_format($debit['debit'], 0, ',', '.') ?>
                                </h4>
                                <div class="text-muted">Total Debit</div>
                            </div>
                            <div class="col-6">

                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <i class="feather-dollar-sign fs-2"></i>
                    </div>
                </div>
                <div class="card-footer bg-success py-3">
                    <div class="hstack justify-content-between">
                        <p class="text-white mb-0">Debit</p>
                    </div>
                </div>
            </div>


        </div>
        <div class="=col-xxxl-3 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="justify-content-between">
                        <div class="row">
                            <div class="col-6">
                                <?php
                                require_once '../../config.php';
                                if (isset($_GET['dari_tanggal']) && isset($_GET['sampai_tanggal'])) {
                                    $sql = mysqli_query($conn, "SELECT sum(kredit) AS kredit FROM jurnal WHERE tanggal_transaksi BETWEEN '$_GET[dari_tanggal]' AND '$_GET[sampai_tanggal]'");
                                    $kredit = mysqli_fetch_array($sql);
                                } else {
                                    $sql = mysqli_query($conn, "SELECT sum(kredit) AS kredit FROM jurnal");
                                    $kredit = mysqli_fetch_array($sql);
                                }
                                ?>
                                <h4 class="text-warning">
                                    <?php echo 'Rp ' . number_format($kredit['kredit'], 0, ',', '.') ?>
                                </h4>
                                <div class="text-muted">Total Kredit</div>
                            </div>
                            <div class="col-6">

                            </div>
                            <div class="text-end">
                                <i class="feather-dollar-sign fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-warning py-3">
                    <div class="hstack justify-content-between">
                        <p class="text-white mb-0">Kredit</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php } ?>
<script>
    $(document).ready(function () {
        $('#tabel-data').DataTable(
            {
                responsive: true
            }
        );

        $('#tabel-data').on('click', '#delete', function () {
            const id = $(this).data('id');
            alertify.confirm('Hapus', 'Apakah anda yakin ingin menghapus transaksi ini? ', function () {
                $.ajax({
                    type: 'POST',
                    url: 'aksi.php?aksi=hapus-transaksi',
                    data: 'id=' + id,
                    success: function (data) {
                        var response = JSON.parse(data);
                        if (response.status == 'success') {
                            alertify.success(response.message);
                            loadTable();
                        } if (response.status == 'error') {
                            alertify.error(response.message);
                        }
                    },
                    error: function (data) {
                        alertify.error('Gagal');
                    }
                })
            }, function () {
                alertify.error('Hapus dibatalkan');
            })
        });
    });
</script>