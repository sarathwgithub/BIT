<?php


class User {
    protected $db;

    public function __construct() {
        $this->db = dbConn();
    }
    
    public function checkUserName($UserName) {
        $sql = "SELECT * FROM users WHERE UserName='$UserName'";
        $result = $this->db->query($sql);
        return $result->num_rows;
    }
    
    public function save($FirstName, $LastName, $UserName, $Password, $UserType, $Status) {
        $pw = password_hash($Password, PASSWORD_BCRYPT);  // Hash the password for security

        // Insert into users table
        $sql = "INSERT INTO users (FirstName, LastName, UserName, Password, UserType, Status) 
                VALUES ('$FirstName', '$LastName', '$UserName', '$pw', '$UserType', '$Status')";
        $this->db->query($sql);

        // Get the newly inserted UserId
        $UserId = $this->db->insert_id;

        return $UserId;
    }
    
    public function getUserData() {
        $sql = "SELECT u.*, e.AppDate, d.Department AS Department, p.Designation AS Designation 
                FROM users u 
                INNER JOIN employee e ON e.UserId = u.UserId 
                LEFT JOIN departments d ON d.Id = e.DepartmentId 
                LEFT JOIN designations p ON p.Id = e.DesignationId";
        $result = $this->db->query($sql);

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function __destruct() {
        $this->db->close();
    }
    
}
