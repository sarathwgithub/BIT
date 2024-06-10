<?php
ob_start();
include_once '../init.php';
$link = "Dashboard";
$breadcrumb_item = "Reports";
$breadcrumb_item_active = "Chart";
?>   


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            
            <!-- /.col (LEFT) -->
            <div class="col-md-6">
                <!-- LINE CHART -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Line Chart</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

               

            </div>
            <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<?php
$content = ob_get_clean();
include '../layouts.php';
?>
<?php
$db = dbConn();
$sql = "SELECT DATE_FORMAT(o.order_date, '%M') as month, SUM(i.unit_price * i.qty) as amt 
        FROM `order_items` i 
        INNER JOIN orders o ON o.id = i.order_id 
        GROUP BY month 
        ORDER BY MONTH(o.order_date)";
$result = $db->query($sql);

$months = [];
$amounts = [];

while ($row = $result->fetch_assoc()) {
    $months[] = $row['month'];
    $amounts[] = $row['amt'];
}

// Encode data as JSON
$months_json = json_encode($months);
$amounts_json = json_encode($amounts);
?>
<script>
    $(document).ready(function () {
        var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
        var months = <?php echo $months_json; ?>;
        var amounts = <?php echo $amounts_json; ?>;

        var lineChartData = {
            labels: months,
            datasets: [
                {
                    label: 'Sales Amount',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: amounts,
                    fill: false  // Ensure the area under the line is not filled
                }
            ]
        };

        var lineChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true
            },
            scales: {
                xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                yAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }]
            }
        };

        // Create the chart
        new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        });
    });
</script>