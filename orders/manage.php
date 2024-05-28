<?php
ob_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="date" name="from_date">
            <input type="date" name="to_date">
            <input type="text" name="item_name" placeholder="Enter Item Name">
            <input type="text" name="supplier_name" placeholder="Enter Suplier Name">
            <button type="submit">Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order Details</h3>

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
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= " item_stock.purchase_date BETWEEN '$from_date' AND '$to_date' AND";
                    }
                    
                    if(!empty($item_name)){
                        $where.=" items.item_name='$item_name' AND";
                    }
                    
                    if(!empty($supplier_name)){
                        $where.=" supplier.supplier_name='$supplier_name' AND";
                    }
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db = dbConn();
                $sql = "SELECT o.*,c.FirstName,c.LastName FROM `orders` o INNER JOIN customers c ON c.CustomerId=o.customer_id";
                $result = $db->query($sql);
                ?>

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Order Date</th>
                            <th>Customer</th>
                            <th>Order Number</th>
                            <th></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['order_date'] ?></td>
                                    <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                                    <td><?= $row['order_number'] ?></td>
                                    <td><a href="view_order_items.php?order_id=<?= $row['id'] ?>">View Order Items</a></td>
                                </tr>

                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

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


