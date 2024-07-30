**Display product details with images and prices using pagination in PHP**
Create MySQL Table
  ```sql
      CREATE TABLE products (
          id INT AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(255) NOT NULL,
          price DECIMAL(10, 2) NOT NULL,
          image_url VARCHAR(255) NOT NULL
      );
      INSERT INTO products (NAME, price, image_url) VALUES
    ('Product 1', 10.00, 'images/product1.jpg'),
    ('Product 2', 15.50, 'images/product2.jpg'),
    ('Product 3', 20.00, 'images/product3.jpg'),
    ('Product 4', 25.00, 'images/product4.jpg'),
    ('Product 5', 30.00, 'images/product5.jpg'),
    ('Product 6', 35.00, 'images/product6.jpg'),
    ('Product 7', 40.00, 'images/product7.jpg'),
    ('Product 8', 45.00, 'images/product8.jpg'),
    ('Product 9', 50.00, 'images/product9.jpg'),
    ('Product 10', 55.00, 'images/product10.jpg');
  ```
Create PHP file
  ```php
      <?php
      include '../function.php';
      
      // Pagination settings
      $items_per_page = 5;
      $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $offset = ($page - 1) * $items_per_page;
      
      $db=dbConn();
      // Fetch product data
      $sql = "SELECT * FROM products LIMIT $items_per_page OFFSET $offset";
      $result = $db->query($sql);
      
      // Fetch total number of products
      $total_sql = "SELECT COUNT(*) FROM products";
      $total_result = $db->query($total_sql);
      $total_row = $total_result->fetch_row();
      $total_items = $total_row[0];
      $total_pages = ceil($total_items / $items_per_page);
      
      
      ?>
      
      <!DOCTYPE html>
      <html lang="en">
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Product List</title>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      </head>
      <body>
      <div class="container mt-5">
          <div class="row">
              <?php if ($result->num_rows > 0){ ?>
                  <?php while ($row = $result->fetch_assoc()){ ?>
                      <div class="col-md-4 mb-4">
                          <div class="card">
                              <img src="<?php echo $row['image_url']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                              <div class="card-body">
                                  <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                  <p class="card-text">$<?php echo number_format($row['price'], 2); ?></p>
                              </div>
                          </div>
                      </div>
                  <?php } ?>
              <?php }else{ ?>
                  <p class="text-center">No products found.</p>
              <?php } ?>
          </div>
      
          <!-- Pagination -->
          <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center">
                  <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                      <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                      </a>
                  </li>
                  <?php for ($i = 1; $i <= $total_pages; $i++){ ?>
                      <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                          <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                      </li>
                  <?php } ?>
                  <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                      <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                      </a>
                  </li>
              </ul>
          </nav>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      </body>
      </html>


  ```
