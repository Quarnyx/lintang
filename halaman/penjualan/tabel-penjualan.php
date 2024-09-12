<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Keranjang</h4>
                <table id="tabel-data" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Harga Jual</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        session_start();
                        include "../../config.php";
                        $total = 0;
                        $harga_beli = 0;
                        $harga_jual = 0;
                        $query = mysqli_query($conn, "SELECT * FROM view_keranjang WHERE kode_penjualan = '$_POST[kode_penjualan]'");
                        while ($data = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?= $data['kode_penjualan'] ?></td>
                                <td><?= $data['nama_produk'] ?></td>
                                <td>Rp. <?= number_format($data['harga_jual'], 0, ',', '.') ?></td>
                                <td><?= $data['qty'] ?></td>
                                <td>Rp. <?= number_format($data['harga_jual'] * $data['qty'], 0, ',', '.') ?></td>
                                <td>
                                    <button data-id="<?= $data['id'] ?>" id="delete" type="button"
                                        class="btn btn-danger">Delete</button>
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

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->

<form id="tambah-penjualan" enctype="multipart/form-data">
    <input type="hidden" name="kode_penjualan" value="<?= $_POST['kode_penjualan'] ?>" id="kode_penjualan">
    <input type="hidden" name="id_pengguna" value="<?= $_SESSION['id'] ?>">
    <input type="hidden" name="harga_jual" value="<?= $harga_jual ?>">
    <input type="hidden" name="harga_beli" value="<?= $harga_beli ?>">
    <div class="row">
        <div class=" col-lg-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Penjualan</label>
                                <input type="date" name="tanggal_transaksi" class="form-control"
                                    value="<?= date('Y-m-d') ?>">
                            </div>
                            <div class=" mb-3">
                                <label for="simpleinput" class="form-label">Bayar</label>
                                <input type="text" name="bayar" class="form-control" placeholder="Bayar" id="bayar">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Total</label>
                                <input type="text" name="total" class="form-control" placeholder="Total"
                                    value="<?php echo $total; ?>" id="total">
                            </div>

                            <div class=" mb-3">
                                <label for="simpleinput" class="form-label">Kembalian</label>
                                <input type="text" name="kembalian" class="form-control" placeholder="Kembalian"
                                    id="kembalian">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div> <!-- end card body-->
        </div>

    </div>
</form>

<script>
    $(document).ready(function () {
        $('#tabel-data').DataTable();
        $('#pelanggan').on('change', function () {
            var alamat = $(this).find(':selected').data('alamat');
            $('textarea[name=alamat]').val(alamat);
        });
        $('.select2').select2();

        $('#tabel-data').on('click', '#delete', function () {
            const id = $(this).data('id');
            alertify.confirm('Hapus', 'Apakah anda yakin ingin menghapus transaksi ini? ', function () {
                $.ajax({
                    type: 'POST',
                    url: 'aksi.php?aksi=hapus-keranjang',
                    data: {
                        id: id
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

        $('#bayar').on('keyup', function () {
            var bayar = $(this).val();
            var total = $('#total').val();
            var kembalian = bayar - total;
            $('#kembalian').val(kembalian);
        });

        $("#tambah-penjualan").submit(function (e) {
            e.preventDefault();
            var bayar = Number($('#bayar').val());
            var total = Number($('#total').val());
            if (bayar < total) {
                console.log($('#bayar').val(), $('#total').val());
                alertify.error('Bayar tidak boleh kurang dari total');
                return false;
            } else {
                var formData = new FormData(this);
                var kode_penjualan = $('#kode_penjualan').val();

                $.ajax({
                    type: 'POST',
                    url: 'aksi.php?aksi=tambah-penjualan',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $(".modal").modal('hide');
                        alertify.confirm('Cetak Faktur', 'Apakah anda ingin mencetak faktur ini?', function () {
                            window.open('halaman/penjualan/cetak-faktur.php?id=' + kode_penjualan, '_blank');
                            window.location.reload();

                        }, function () {
                            alertify.error('Cetak dibatalkan');
                        })

                    },
                    error: function (data) {
                        alertify.error(data);
                    }
                });
            }
        });


    });
</script>