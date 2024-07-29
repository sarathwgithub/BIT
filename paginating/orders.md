-------------------------------------
**PHP code to paginate**
-------------------------------------
1. Create Database Table
   ```sql
      CREATE TABLE orders (
          id INT AUTO_INCREMENT PRIMARY KEY,
          order_number VARCHAR(50),
          order_date DATE,
          customer_name VARCHAR(100)
      );

       INSERT INTO orders (order_number, order_date, customer_name) VALUES
        ('ORD001', '2024-07-01', 'John Doe'),
        ('ORD002', '2024-07-02', 'Jane Smith'),
        ('ORD003', '2024-07-03', 'Alice Johnson'),
        ('ORD004', '2024-07-04', 'Robert Brown'),
        ('ORD005', '2024-07-05', 'Emily Davis'),
        ('ORD006', '2024-07-06', 'Michael Wilson'),
        ('ORD007', '2024-07-07', 'Sarah Miller'),
        ('ORD008', '2024-07-08', 'David Lee'),
        ('ORD009', '2024-07-09', 'Laura Clark'),
        ('ORD010', '2024-07-10', 'James Martinez'),
        ('ORD011', '2024-07-11', 'Susan Lewis'),
        ('ORD012', '2024-07-12', 'Paul Walker'),
        ('ORD013', '2024-07-13', 'Lisa Hall'),
        ('ORD014', '2024-07-14', 'Daniel Young'),
        ('ORD015', '2024-07-15', 'Nancy Allen'),
        ('ORD016', '2024-07-16', 'Mark Hernandez'),
        ('ORD017', '2024-07-17', 'Jessica King'),
        ('ORD018', '2024-07-18', 'Andrew Wright'),
        ('ORD019', '2024-07-19', 'Karen Lopez'),
        ('ORD020', '2024-07-20', 'Christopher Hill');

   ```
3. Create PHP file
    ```php
        <?php
        // Database connection
        include '../../function.php';
        
        $db = dbConn();
        
        // Pagination variables
        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        } else {
            $limit = 10; // Default number of records per page
        }
        
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;
        
        // Fetch total number of records
        $result = $db->query("SELECT COUNT(*) AS total_records FROM orders");
        $total_records = $result->fetch_assoc()['total_records'];
        $total_pages = ceil($total_records / $limit);
        
        // Fetch records for the current page
        echo $sql = "SELECT * FROM orders LIMIT $offset, $limit";
        $result = $db->query($sql);
        ?>
        <form method='get' action=''>
            <label for='limit'>Records per page:</label>
            <select name='limit' id='limit' onchange='this.form.submit()'>
                <option value='5'" <?= ($limit == 5 ? " selected" : "") ?> >5</option>
                <option value='10' <?= ($limit == 10 ? " selected" : "") ?>>10</option>
                <option value='20' <?= ($limit == 20 ? " selected" : "")?>>20</option>
                <option value='50' <?= ($limit == 50 ? " selected" : "") ?>>50</option>
            </select>
            <noscript><input type='submit' value='Go'></noscript>
        </form>
        
        <table border='1'>
        <tr>
            <th>ID</th>
            <th>Order Number</th>
            <th>Order Date</th>
            <th>Customer Name</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['order_number'] ?></td>
                    <td><?= $row['order_date'] ?></td>
                    <td><?= $row['customer_name'] ?></td>
                </tr>
            <?php
            }
        } else {
            ?>
            <tr>
                <td colspan='4'>No records found</td>
            </tr>
        <?php
        }
        ?>
        </table>
        
        <!--Pagination controls-->
        <div style='margin-top: 20px;'>
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
            ?>
                <a href='?page=<?=$i?>&limit=<?=$limit?>'><?=$i?></a>
            <?php
            }
            ?>
        </div>
        
        

    ```
4. 
