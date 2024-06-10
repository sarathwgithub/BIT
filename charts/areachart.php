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
            <div class="col-md-6">
                <!-- AREA CHART -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Area Chart</h3>

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
                            <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

               
                
            </div>
         
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<?php
$content = ob_get_clean();
include '../layouts.php';
?>
<script>
    $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //--------------
        //- AREA CHART -
        //--------------

        // Get context with jQuery - using jQuery's .get() method.
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
        var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
        var months = <?php echo $months_json; ?>;
        var amounts = <?php echo $amounts_json; ?>;
        var areaChartData = {
            labels: months,
            datasets: [
                {
                    label: 'Digital Goods',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: amounts
                }
                
            ]
        }

        var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
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
        }

        // This will get the first returned node in the jQuery collection.
        new Chart(areaChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: areaChartOptions
        })

        

        

        

       

       

        

       
    })
</script>