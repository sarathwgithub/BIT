<?php
ob_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "View Items";

extract($_GET);

$db = dbConn();
$sql = "SELECT o.*,c.FirstName,c.LastName FROM `orders` o INNER JOIN customers c ON c.CustomerId=o.customer_id WHERE o.id='$order_id'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
?> 
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order Item Details</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h4>Customer Details</h4>
                                <?= $row['FirstName'] ?> <?= $row['LastName'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h4>Billing Details</h4>
                                <?= $row['billing_name'] ?> 
                                <br>
                                <?= $row['billing_address'] ?>   
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h4>Delivery Details</h4>
                                <?= $row['delivery_name'] ?> 
                                <br>
                                <?= $row['delivery_address'] ?> 
                                <br>
                                <?= $row['delivery_phone'] ?> 
                            </div>
                        </div>
                    </div>
                </div>


                <?php
                $db = dbConn();
                echo $sql = "SELECT 
    o.order_id,
    o.item_id,
    o.unit_price,
    o.qty,
    i.item_name,
    
    (COALESCE(stock_totals.total_qty, 0) - COALESCE(stock_totals.total_issued_qty, 0)) AS balance_qty
FROM 
    order_items o 
INNER JOIN 
    items i ON i.id = o.item_id 
LEFT JOIN 
    (
        SELECT 
            item_id,
            unit_price,
            SUM(qty) AS total_qty, 
            SUM(issued_qty) AS total_issued_qty 
        FROM 
            item_stock 
        GROUP BY 
            item_id,unit_price
    ) AS stock_totals ON stock_totals.item_id = o.item_id and  stock_totals.unit_price=o.unit_price
WHERE 
    o.order_id = '$order_id'
GROUP BY 
    o.order_id, o.item_id, o.unit_price;
";
                $result = $db->query($sql);
                ?>
                <form action="../inventory/issue.php" method="post">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Unit Price</th>
                                <th>Ordered Qty</th>
                                <th>Balance Qty</th>
                                <th>Issued Qty</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?= $row['item_name'] ?></td>
                                        <td><?= $row['unit_price'] ?></td>
                                        <td><?= $row['qty'] ?></td>
                                        <td><?= $row['balance_qty'] ?></td>
                                        <td>
                                            <input type="text" name="items[]" value="<?= $row['item_id'] ?>">
                                            <input type="text" name="order_id" value="<?= $row['order_id'] ?>">
                                            <input type="text" name="prices[]" value="<?= $row['unit_price'] ?>">
                                           
                                            <input type="text" name="issued_qty[]">
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Issue</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>

