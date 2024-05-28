<?php

include_once '../init.php';
$db = dbConn();
extract($_POST);

foreach ($issued_qty as $key => $qty) {
    
    $issue_qty = $qty;
    $item=$items[$key];
    $price=$prices[$key];
    
    while ($issue_qty > 0) {
        // Select the stock with available quantity, ordered by purchase date (FIFO)
        echo $sql = "SELECT *
                FROM `item_stock`
                WHERE item_id = '$item' 
                  AND unit_price = '$price'
                  AND (qty - COALESCE(issued_qty, 0)) > 0
                ORDER BY `purchase_date` ASC
                LIMIT 1";
        $result = $db->query($sql);

        // If no more stock available, break the loop to avoid infinite loop
        if ($result->num_rows == 0) {           
            break;
        }

        $row = $result->fetch_assoc();
        $remaining_qty = $row['qty'] - ($row['issued_qty'] ?? 0);
        $item_id=$row['item_id'];
        $unit_price = $row['unit_price'];
        $i_date = date('Y-m-d');

        if ($issue_qty <= $remaining_qty) {
            $i_qty = $issue_qty;
            $s_id = $row['id'];
            $sql = "UPDATE `item_stock` SET issued_qty = COALESCE(issued_qty, 0) + $i_qty WHERE id = $s_id";
            $db->query($sql);
            $sql = "INSERT INTO order_items_issue(order_id, item_id, stock_id, unit_price, issued_qty, issue_date) 
                    VALUES ('$order_id', '$item_id', '$s_id', '$unit_price', '$i_qty', '$i_date')";
            $db->query($sql);
            $issue_qty = 0;  // All quantity issued
        } else {
            $i_qty = $remaining_qty;
            $s_id = $row['id'];
            $sql = "UPDATE `item_stock` SET issued_qty = COALESCE(issued_qty, 0) + $i_qty WHERE id = $s_id";
            $db->query($sql);
            $sql = "INSERT INTO order_items_issue(order_id, item_id, stock_id, unit_price, issued_qty, issue_date) 
                    VALUES ('$order_id', '$item_id', '$s_id', '$unit_price', '$i_qty', '$i_date')";
            $db->query($sql);
            $issue_qty -= $i_qty;  // Reduce the remaining quantity to be issued
        }
    }
}
header("Location:../orders/view_order_items.php?order_id=$order_id");
