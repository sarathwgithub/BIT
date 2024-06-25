--------------------------------------------------------------
**Check Front end user can log in to the back end system and the Back end user can log in to the front end system validation**
--------------------------------------------------------------
1. Add new coloumn as user_role to user table(The value is Front End - F and Back End - B)
2. Write the below function in your function file
    ```php
      function checkRole($role=null){
        $user_id=$_SESSION['USERID'];
        $db = dbConn();
        $sql = "SELECT * FROM users u WHERE u.UserId='$user_id' AND u.user_role='$role' ";
    
        $result = $db->query($sql);
    
        if ($result->num_rows <= 0) {
            header("Location:../unauthorized.php");
            return false;
        } else {
            return true;
        }
      }
3. Create unauthorized.php file in your project root folder
    ```html
      <!DOCTYPE html>
      <html lang="en">
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Unauthorized Access</title>
          <style>
              body {
                  font-family: Arial, sans-serif;
                  background-color: #f2f2f2;
                  text-align: center;
                  padding: 50px;
              }
              .container {
                  background-color: white;
                  padding: 20px;
                  border-radius: 10px;
                  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                  display: inline-block;
                  margin-top: 50px;
              }
              h1 {
                  color: #d9534f;
              }
              p {
                  color: #333;
              }
              a {
                  color: #0275d8;
                  text-decoration: none;
                  font-weight: bold;
              }
              a:hover {
                  text-decoration: underline;
              }
          </style>
      </head>
      <body>
          <div class="container">
              <h1>Unauthorized Access</h1>
              <p>Sorry, you are not authorized to access this page.</p>
              <p>Please <a href="web/login.php">go back</a> and try logging in with the correct credentials.</p>
          </div>
      </body>
      </html>

4. Now you can call the checkRole() function at the top of each page, passing 'F' for a front-end page and 'B' for a back-end page.
  Ex: for front end checkRole("F") or for back end checkRole("B")
  ```php
    checkRole("F")
   
