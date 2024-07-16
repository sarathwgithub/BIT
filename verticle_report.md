------------------------------------------------------------------------
**Creating a report where student names are listed vertically and subject names horizontally with respective marks, total marks for all subjects, average marks, and rank can be achieved with a combination of SQL queries and PHP code.**
-----------------------------------------------------------------------
Step 01- Sample Data
  ```sql
    CREATE TABLE subject (
        subjectid INT PRIMARY KEY,
        subjectname VARCHAR(50)
    );
    
    CREATE TABLE student (
        studentid INT PRIMARY KEY,
        name VARCHAR(50)
    );
    
    CREATE TABLE exam_result (
        id INT PRIMARY KEY AUTO_INCREMENT,
        date DATE,
        studentid INT,
        subjectid INT,
        marks INT,
        FOREIGN KEY (studentid) REFERENCES student(studentid),
        FOREIGN KEY (subjectid) REFERENCES subject(subjectid)
    );
    
    -- Insert sample data
    INSERT INTO subject (subjectid, subjectname) VALUES
    (1, 'Math'),
    (2, 'Science'),
    (3, 'English');
    
    INSERT INTO student (studentid, name) VALUES
    (1, 'Alice'),
    (2, 'Bob'),
    (3, 'Charlie');
    
    INSERT INTO exam_result (date, studentid, subjectid, marks) VALUES
    ('2024-07-01', 1, 1, 85),
    ('2024-07-01', 1, 2, 90),
    ('2024-07-01', 1, 3, 78),
    ('2024-07-01', 2, 1, 80),
    ('2024-07-01', 2, 2, 85),
    ('2024-07-01', 2, 3, 88),
    ('2024-07-01', 3, 1, 75),
    ('2024-07-01', 3, 2, 70),
    ('2024-07-01', 3, 3, 65);

  ```
Step 02: PHP Code
  ```php
    <?php
      include '../function.php';
      
      $db= dbConn();
      // Prepare the dynamic SQL query
      $sql = "SELECT 
                  s.name AS student_name,
                  SUM(CASE WHEN r.subjectid = 1 THEN r.marks ELSE 0 END) AS Math,
                  SUM(CASE WHEN r.subjectid = 2 THEN r.marks ELSE 0 END) AS Science,
                  SUM(CASE WHEN r.subjectid = 3 THEN r.marks ELSE 0 END) AS English,
                  SUM(r.marks) AS total_marks,
                  AVG(r.marks) AS average_marks
              FROM 
                  student s
              JOIN 
                  exam_result r ON s.studentid = r.studentid
              GROUP BY 
                  s.studentid
              ORDER BY 
                  total_marks DESC";
      $result = $db->query($sql);
      if ($result->num_rows > 0) {
          echo "<table border='1'>
                  <tr>
                      <th>Student Name</th>
                      <th>Math</th>
                      <th>Science</th>
                      <th>English</th>
                      <th>Total Marks</th>
                      <th>Average Marks</th>
                      <th>Rank</th>
                  </tr>";
      
          $rank = 1;
          while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['student_name']}</td>
                      <td>{$row['Math']}</td>
                      <td>{$row['Science']}</td>
                      <td>{$row['English']}</td>
                      <td>{$row['total_marks']}</td>
                      <td>{$row['average_marks']}</td>
                      <td>{$rank}</td>
                    </tr>";
              $rank++;
          }
      
          echo "</table>";
      } else {
          echo "0 results";
      }
      
      
      ?>

  ```
