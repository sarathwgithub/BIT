-------------------------------------------------------
**Product Comparison**
-------------------------------------------------------
1. Create Product Table
   ```sql
     CREATE TABLE `products` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) DEFAULT NULL,
    `description` text DEFAULT NULL,
    `price` decimal(10,2) DEFAULT NULL,
    `image_url` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    )
2. Insert below data
   ```sql
      insert  into `products`(`id`,`name`,`description`,`price`,`image_url`) values 
      (1,'ZTE Blade V50 Design (Green)','Delivery - Standard 3 To 5 Working Days\r\n1 Years(s) Manufacturer Warranty',45650.00,'ZTE-V50DESIGN-8-256GB-GRE-01.webp'),
      (2,'Samsung Galaxy A05 (Green)','Easy Installment Available\r\nOffer - Extra 18100 off (Price is inclusive of Discount)',43299.00,'SMG-SM-A055F-6-128-G-01.webp'),
      (3,'Huawei Nova 9 SE (Blue)','Delivery - Standard 3 To 5 Working Days\r\n1 Years(s) Manufacturer Warranty\r\n',79999.00,'HU-NOVA9SE-BLU-01.webp');
4. Create Product Features Table
   ```sql
       CREATE TABLE `productfeatures` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `product_id` int(11) DEFAULT NULL,
      `feature_name` varchar(100) DEFAULT NULL,
      `feature_value` varchar(100) DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `product_id` (`product_id`),
      CONSTRAINT `productfeatures_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
      )
5. Insert below data
   ```sql
      insert  into `productfeatures`(`id`,`product_id`,`feature_name`,`feature_value`) values 
      (1,1,'RAM','8GB'),
      (2,1,'Size','1080 x 2408 pixels, 6.6 inches'),
      (3,1,'Camera','50MP + 2MP + 2MP + 8MP Selfie'),
      (4,2,'RAM','6GB'),
      (5,2,'Size','720 x 1600 pixels'),
      (6,2,'Camera','50 MP + 2 MP + 8 MP Selfie'),
      (7,3,'RAM','8GB'),
      (8,3,'Size','FHD + 2388 × 1080 pixels; 387 PPI'),
      (9,3,'Camera','108 MP High-Res Photography');
5. Create the HTML Form for Selecting Products
   ```html
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
                
            </div>
            <button type="submit">Compare Selected Products</button>
        </form>
     </body>
   </html>
6. Fetch Products and Display as Checkboxes
   ```php
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
                
7. Handle the Comparison Logic in PHP
   ```php
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
   
