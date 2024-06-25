<?php
include '../../function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Comparison</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .product {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            display: inline-block;
            width: 200px;
        }

        .comparison {
            margin-top: 20px;
        }

        .comparison table {
            width: 100%;
            border-collapse: collapse;
        }

        .comparison table,
        .comparison th,
        .comparison td {
            border: 1px solid #ccc;
        }

        .comparison th,
        .comparison td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Product Comparison</h1>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div id="product-list">
            <?php
            $db = dbConn();
            $sql = "SELECT * FROM products";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product">';
                    echo '<h2>' . $row['name'] . '</h2>';
                    echo '<img src="' . $row['image_url'] . '" alt="' . $row['name'] . '" style="width:100%">';
                    echo '<p>' . $row['description'] . '</p>';
                    echo '<p>Price: Rs.' . $row['price'] . '</p>';
                    echo '<input type="checkbox" name="productIds[]" value="' . $row['id'] . '"> Select to compare';
                    echo '</div>';
                }
            } else {
                echo 'No products found.';
            }
            ?>
        </div>
        <button type="submit">Compare Selected Products</button>
    </form>
    <?php
    extract($_POST);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['productIds'])) {
            
            if (empty($productIds)) {
                echo '<p>No products selected for comparison</p>';
                return;
            }
        
            $db = dbConn();
            $ids = implode(',', $productIds);
            echo $sql = "SELECT p.id, p.name, p.description, p.price, p.image_url, 
                    pf.feature_name, pf.feature_value 
                    FROM products p 
                    LEFT JOIN productFeatures pf ON p.id = pf.product_id 
                    WHERE p.id IN ($ids)";
            $result = $db->query($sql);
        
            if ($result->num_rows > 0) {
                $products = [];
                while ($row = $result->fetch_assoc()) {
                    $productId = $row['id'];
                    if (!isset($products[$productId])) {
                        $products[$productId] = [
                            'id' => $row['id'],
                            'name' => $row['name'],
                            'description' => $row['description'],
                            'price' => $row['price'],
                            'image_url' => $row['image_url'],
                            'features' => []
                        ];
                    }
                    $products[$productId]['features'][$row['feature_name']] = $row['feature_value'];
                }
        
                echo '<div class="comparison">';
                echo '<table>';
                echo '<thead>';
                echo '<tr><th>Product</th><th>Price</th><th>Features</th></tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($products as $product) {
                    echo '<tr>';
                    echo '<td>' . $product['name'] . '</td>';
                    echo '<td> RS' . $product['price'] . '</td>';
                    echo '<td>';
                    foreach ($product['features'] as $featureName => $featureValue) {
                        echo $featureName . ': ' . $featureValue . '<br>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            } else {
                echo '<p>No matching products found</p>';
            }
        } else {
            echo '<p>No products selected for comparison</p>';
        }
    }
    ?>
</body>

</html>