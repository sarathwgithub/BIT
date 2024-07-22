**Chaeck available beauticians**
MySQL Tables
  ```sql
      -- Create the beautician table
      CREATE TABLE beautician (
          id INT PRIMARY KEY AUTO_INCREMENT,
          name VARCHAR(255)
      );
      
      -- Insert sample data into beautician table
      INSERT INTO beautician (name) VALUES ('Alice'), ('Bob'), ('Charlie');
      
      -- Create the booking table
      CREATE TABLE booking (
          bookingid INT PRIMARY KEY AUTO_INCREMENT,
          date DATE,
          time TIME,
          beauticianid INT,
          FOREIGN KEY (beauticianid) REFERENCES beautician(id)
      );
      
      -- Insert sample data into booking table
      INSERT INTO booking (date, time, beauticianid) VALUES
      ('2024-07-23', '10:00:00', 1),
      ('2024-07-23', '11:00:00', 2);
  ```
PHP Code
  ```php
      <?php
      include '../function.php';
      
      // Function to get available beauticians
      function getAvailableBeauticians($date, $time) {
          $db=dbConn();
          // SQL query to get beauticians who are not booked within the 15-minute window
          $sql = "
              SELECT b.id, b.name 
              FROM beautician b 
              LEFT JOIN booking bo 
              ON b.id = bo.beauticianid 
              AND bo.date = '$date' 
              AND (
                  (bo.time <= '$time' AND ADDTIME(bo.time, '00:15:00') > '$time') OR
                  (bo.time > '$time' AND '$time' >= SUBTIME(bo.time, '00:15:00'))
              )
              WHERE bo.beauticianid IS NULL";
          
          $result = $db->query($sql);
      
          if ($result->num_rows > 0) {
              $availableBeauticians = [];
              while ($row = $result->fetch_assoc()) {
                  $availableBeauticians[] = $row;
              }
              return $availableBeauticians;
          } else {
              return [];
          }
      }
      
      // Example usage
      $date = '2024-07-23';  // Set the desired date
      $time = '10:30:00';   // Set the desired time
      
      $availableBeauticians = getAvailableBeauticians($date, $time);
      
      echo "Available Beauticians:\n";
      foreach ($availableBeauticians as $beautician) {
          echo "ID: " . $beautician['id'] . ", Name: " . $beautician['name'] . "\n";
      }
      ?>

  ```
