<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-primary border-primary border shadow">
                                <i class="fe-bar-chart-line font-22 avatar-title text-white"></i>
                            </div>
                        </div>
                        <?php
                        require_once 'config.php';

                        $sql = "SELECT SUM(total) AS total FROM view_keranjang WHERE MONTH(tanggal_transaksi) = MONTH(CURDATE()) AND YEAR(tanggal_transaksi) = YEAR(CURDATE())";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total = $row['total'];
                        } else {
                            $total = 0;
                        }
                        ?>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">Rp<span
                                        data-plugin="counterup"><?= number_format($total) ?></span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Total Pendapatan Bulan Ini</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-success border-success border shadow">
                                <i class="fe-shopping-cart font-22 avatar-title text-white"></i>
                            </div>
                        </div>
                        <?php
                        require_once 'config.php';

                        $sql = "SELECT SUM(total) AS total FROM view_pembelian WHERE MONTH(tanggal_transaksi) = MONTH(CURDATE()) AND YEAR(tanggal_transaksi) = YEAR(CURDATE())";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total = $row['total'];
                        } else {
                            $total = 0;
                        }
                        ?>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">Rp <span
                                        data-plugin="counterup"><?= number_format($total) ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Pembelian Bulan Ini</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-info border-info border shadow">
                                <i class="fe-bar-chart-line- font-22 avatar-title text-white"></i>
                            </div>
                        </div>
                        <?php
                        require_once 'config.php';

                        $sql = "SELECT COUNT(id) AS total FROM penjualan WHERE tanggal_transaksi = CURDATE()";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total = $row['total'];
                        } else {
                            $total = 0;
                        }
                        ?>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?= $total ?></span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Transaksi Hari Ini</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-warning border-warning border shadow">
                                <i class="fe-eye font-22 avatar-title text-white"></i>
                            </div>
                        </div>
                        <?php
                        require_once 'config.php';

                        $sql = "SELECT COUNT(id) AS total FROM pengguna";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total = $row['total'];
                        } else {
                            $total = 0;
                        }
                        ?>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?= $total ?></span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Total Pengguna</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->

    <div class="row">


        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pb-2">


                    <h4 class="header-title mb-3">Grafik Transaksi</h4>

                    <div dir="ltr">
                        <div id="sales_figures" data-colors='["#1abc9c", "#4a81d4"]' class="apex-charts" dir="ltr">
                        </div>
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col-->
        </div>
        <!-- end row -->



    </div>
</div> <!-- container -->

<?php
$sqljual = "SELECT
                YEAR(tanggal_transaksi) AS year,
                MONTH(tanggal_transaksi) AS month,
                COUNT(*) AS sales_count
            FROM
	            view_keranjang
                WHERE YEAR(tanggal_transaksi) = YEAR(CURDATE())
            GROUP BY year, month";
$sqlbeli = "SELECT
                YEAR(tanggal_transaksi) AS year,
                MONTH(tanggal_transaksi) AS month,
                COUNT(*) AS buys_count
            FROM
	            view_pembelian
                WHERE YEAR(tanggal_transaksi) = YEAR(CURDATE())
            GROUP BY year, month";

$sales_result = $conn->query($sqljual);
$sales_data = [];

if ($sales_result->num_rows > 0) {
    while ($row = $sales_result->fetch_assoc()) {
        $sales_data[] = $row;
    }
}

$buys_result = $conn->query($sqlbeli);
$buys_data = [];

if ($buys_result->num_rows > 0) {
    while ($row = $buys_result->fetch_assoc()) {
        $buys_data[] = $row;
    }
}

// Preparing data for ApexCharts
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
$sales_counts = array_fill(0, 12, 0);  // Initialize an array with 12 zeros
$buys_counts = array_fill(0, 12, 0);   // Initialize an array with 12 zeros

// Map buys data to corresponding months
foreach ($buys_data as $data) {
    $buys_counts[$data['month'] - 1] = $data['buys_count'];
}
// echo "<pre>";
// print_r($buys_counts);
// echo "</pre>";
// Map sales data to corresponding months
foreach ($sales_data as $data) {
    $sales_counts[$data['month'] - 1] = $data['sales_count'];
}
// echo "<pre>";
// print_r($sales_counts);
// echo "</pre>";



$conn->close();
?>
<script>
    function getChartColorsArray(e) {
        if (null !== document.getElementById(e)) {
            var t = document.getElementById(e).getAttribute("data-colors");
            if (t)
                return (t = JSON.parse(t)).map(function (e) {
                    var t = e.replace(" ", "");
                    if (-1 === t.indexOf(",")) {
                        var o = getComputedStyle(document.documentElement).getPropertyValue(
                            t
                        );
                        return o || t;
                    }
                    var r = e.split(",");
                    return 2 != r.length
                        ? t
                        : "rgba(" +
                        getComputedStyle(document.documentElement).getPropertyValue(
                            r[0]
                        ) +
                        "," +
                        r[1] +
                        ")";
                });
        }
    }
    const salesCounts = <?php echo json_encode($sales_counts); ?>;
    const buysCounts = <?php echo json_encode($buys_counts); ?>;
    const months = <?php echo json_encode($months); ?>;
    var chartColumnStacked100Colors = getChartColorsArray("sales_figures");
    chartColumnStacked100Colors &&
        ((options = {
            series: [
                {
                    name: "Penjualan",
                    data: salesCounts,
                },
                {
                    name: "Pembelian",
                    data: buysCounts,
                },
            ],
            dataLabels: { enabled: !1 },
            chart: {
                type: "bar",
                height: 400,
                stacked: !0,
                stackType: "",
                toolbar: { show: !1 },
                borderRadius: 30,
                animations: {
                    enabled: !0,
                    easing: "easeinout",
                    speed: 800,
                    animateGradually: { enabled: !0, delay: 150 },
                    dynamicAnimation: { enabled: !0, speed: 350 },
                },
            },
            stroke: { width: 3, colors: ["#fff"] },
            plotOptions: { bar: { borderRadius: 6, columnWidth: "20%" } },
            responsive: [
                {
                    breakpoint: 850,
                    options: {
                        chart: { height: 300 },
                        plotOptions: { bar: { columnWidth: "30%" } },
                    },
                },
                {
                    breakpoint: 620,
                    options: {
                        series: [
                            { data: [44, 55, 41, 67, 22, 43, 21, 49, 30] },
                            { data: [13, 23, 20, 8, 13, 27, 33, 12, 10] },
                        ],
                        plotOptions: { bar: { columnWidth: "40%" } },
                    },
                },
                {
                    breakpoint: 480,
                    options: { legend: { position: "bottom", offsetX: -10, offsetY: 0 } },
                },
                {
                    breakpoint: 350,
                    options: {
                        series: [
                            { data: [44, 55, 41, 67, 22, 43, 21] },
                            { data: [13, 23, 20, 8, 13, 27, 33] },
                        ],
                        plotOptions: { bar: { columnWidth: "50%" } },
                    },
                },
            ],
            xaxis: {
                categories: months,
            },
            fill: { opacity: 1 },
            legend: { show: !1 },
            colors: chartColumnStacked100Colors,
        }),
            (chart = new ApexCharts(
                document.querySelector("#sales_figures"),
                options
            )).render());
</script>