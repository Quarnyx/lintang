<table id="tabel-data" class="table dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Nama Supplier</th>
            <th>Harga Beli</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "../../config.php";
        $query = mysqli_query($conn, "SELECT * FROM view_pembelian");
        while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?= $data['kode_pembelian'] ?></td>
                <td><?= $data['nama_produk'] ?></td>
                <td><?= $data['nama_supplier'] ?></td>
                <td>Rp. <?= number_format($data['harga_beli'], 0, ',', '.') ?></td>
                <td><?= $data['qty'] ?></td>
                <td>Rp. <?= number_format($data['harga_beli'] * $data['qty'], 0, ',', '.') ?></td>
                <td>
                    <button data-id="<?= $data['id'] ?>" id="edit" type="button" class="btn btn-primary">Edit</button>
                    <button data-id="<?= $data['id'] ?>" data-kodetransaksi="<?= $data['kode_pembelian'] ?>" id="delete"
                        type="button" class="btn btn-danger">Delete</button>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#tabel-data').DataTable();
        $('#tabel-data').on('click', '#edit', function () {
            const id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: 'halaman/pembelian/edit-pembelian.php',
                data: 'id=' + id,
                success: function (data) {
                    $('.modal').modal('show');
                    $('.modal-title').html('Edit Data ' + name);
                    $('.modal .modal-body').html(data);
                }
            })
        });

        $('#tabel-data').on('click', '#delete', function () {
            const kode_transaksi = $(this).data('kodetransaksi');
            alertify.confirm('Hapus', 'Apakah anda yakin ingin menghapus transaksi ini? ', function () {
                $.ajax({
                    type: 'POST',
                    url: 'aksi.php?aksi=hapus-pembelian',
                    data: {
                        kode_transaksi: kode_transaksi
                    },
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