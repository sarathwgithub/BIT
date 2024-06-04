<?php


class Employee extends User {
    
    public function __construct() {
        parent::__construct();  // Call the parent constructor to initialize the database connection
    }    
    public function save($FirstName=null, $LastName=null, $UserName=null, $Password=null, $AppDate=null, $DesignationId=null, $DepartmentId=null) {
        // Insert user and get the UserId
        $UserId = parent::save($FirstName, $LastName, $UserName, $Password, 'employee', '1');

        // Insert into employee table
        $sql = "INSERT INTO employee (AppDate, DesignationId, DepartmentId, UserId) 
                VALUES ('$AppDate', '$DesignationId', '$DepartmentId', '$UserId')";
        $this->db->query($sql);
    }
    
}
