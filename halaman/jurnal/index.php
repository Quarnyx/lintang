<?php
$sub_title = "Jurnal Umum";
$title = "Jurnal";
include 'partials/page-title.php'; ?>

<div class="row mb-2">
    <div class="col-sm-4">
        <button id="tambah" class="btn btn-success rounded-pill waves-effect waves-light mb-3"><i
                class="mdi mdi-plus"></i> Tambah Transaksi</button>
    </div>
</div>
<!-- end row-->
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
                    <input type="hidden" name="halaman" value="jurnal">
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
                        <?php if (isset($_GET['dari_tanggal']) && isset($_GET['sampai_tanggal'])) { ?>
                            <a target="_blank"
                                href="halaman/jurnal/cetak.php?dari_tanggal=<?= $daritanggal ?>&sampai_tanggal=<?= $sampaitanggal ?>"
                                class="btn btn-success">Cetak</a>
                        <?php } ?>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Jurnal Umum</h4>
                <div id="load-table">

                </div>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->

<script>
    <?php if (!isset($_GET['dari_tanggal']) && !isset($_GET['sampai_tanggal'])) { ?>
        function loadTable() {
            $('#load-table').load('halaman/jurnal/tabel-jurnal.php')
        }
    <?php } else { ?>
        function loadTable() {
            $('#load-table').load('halaman/jurnal/tabel-jurnal.php?dari_tanggal=' + '<?= $daritanggal ?>&sampai_tanggal=' + '<?= $sampaitanggal ?>')
        }
    <?php } ?>
    $(document).ready(function () {
        loadTable();
        $('#tambah').on('click', function () {
            $('.modal').modal('show');
            $('.modal-title').html('Tambah Transaksi');
            // load form
            $('.modal-body').load('halaman/jurnal/tambah-transaksi.php');
        });
    });
</script>