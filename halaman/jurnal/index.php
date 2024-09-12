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
                <h5 class="card-title mb-0">Filter Periode</h5>
            </div><!-- end card header -->
            <?php
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
            if (isset($_GET['bulan'])) {
                $titlebulan = bulan($_GET['bulan']);
            } else {
                $titlebulan = bulan(date('m'));

            }

            ?>
            <div class="card-body">
                <form action="" method="get" class="row g-3">
                    <input type="hidden" name="halaman" value="jurnal">
                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Bulan</label>
                        <select class="form-select" name="bulan" id="validationDefault01">
                            <option selected disabled value="">Pilih Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Pilih</button>
                        <?php if (isset($_GET['bulan'])) { ?>
                            <a target="_blank" href="halaman/jurnal/cetak.php?bulan=<?= $_GET['bulan'] ?>"
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
    <?php if (!isset($_GET['bulan'])) { ?>
        function loadTable() {
            $('#load-table').load('halaman/jurnal/tabel-jurnal.php')
        }
    <?php } else {
        $bulan = $_GET['bulan']; ?>
        function loadTable() {
            $('#load-table').load('halaman/jurnal/tabel-jurnal.php?bulan=' + '<?= $bulan ?>')
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