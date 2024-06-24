----------------------------------------------------------------------
**Creating a chat application using AJAX, PHP, and MySQL**
----------------------------------------------------------------------
1. Setting Up the Database
   create a MySQL table to store chat messages
   ```msql
   CREATE TABLE messages(
      id int(11) NOT NULL AUTO_INCREMENT,
      user_id int(11) DEFAULT NULL,
      username varchar(50) DEFAULT NULL,
      message text DEFAULT NULL,
      timestamp timestamp NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (id)
    )
  
2. Fetch Messages (fetch_messages.php)
   This script will fetch the latest messages from the database.
   ```php
     include '../../function.php';
      $db = dbConn();
      
      $sql = "SELECT * FROM messages ORDER BY timestamp DESC";
      $result = $db->query($sql);
      
      $messages = array();
      while ($row = $result->fetch_assoc()) {
          $messages[] = $row;
      }
      
      // Ensure we return valid JSON
      //header('Content-Type: application/json');
      echo json_encode($messages);
  3. Send Message (send_message.php):
     This script will handle incoming messages and store them in the database.
     ```php
        session_start();
        include '../../function.php';
        $db=dbConn();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);   
            $user_id=$_SESSION['USERID'];
            $username=$_SESSION['FIRSTNAME'];
            $sql="INSERT INTO messages (user_id,username, message) VALUES ('$user_id','$username', '$message')";
            $db->query($sql);
            
        }
4. Front end Code(index.html)
   ```html   
         <?php
        include '../../config.php';
        include '../header.php';
        ?>
        <style>
            #chat-box {
                width: 100%;
                height: 400px;
                border: 1px solid #ccc;
                overflow-y: scroll;
                margin-bottom: 10px;
                padding: 10px;
            }
        
            #chat-form {
                display: flex;
                justify-content: space-between;
            }
        
            #chat-form input[type="text"] {
                width: 90%;
                padding: 5px;
            }
        
            #chat-form button {
                padding: 5px 10px;
            }
        </style>
        <main id="main">
            <!-- ======= Contact Us Section ======= -->
        
            <div class="container">
        
        
                <h2>Chat Application</h2>
        
                <div id="chat-box"></div>
                <form id="chat-form">
                    <input type="text" id="message" class="form-control border border-1 border-dark" placeholder="Type a message">
                    <button type="submit" class="btn btn-warning">Send</button>
                </form>
        
        
            </div>
        </main>
        <?php
        include '../footer.php';
        ?>
        
        <script>
            $(document).ready(function() {
                function fetchMessages() {
                    $.ajax({
                        url: 'fetch_messages.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            let chatBox = '';
                            data.forEach(function(message) {
                                chatBox += '<p><strong>' + message.username + ':</strong> ' + message.message + ' <em>(' + message.timestamp + ')</em></p>';
                            });
                            $('#chat-box').html(chatBox);
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX error:", status, error);
                        }
                    });
                }
        
                $('#chat-form').on('submit', function(event) {
                    event.preventDefault();
                    const message = $('#message').val();
                    $.ajax({
                        url: 'send_message.php',
                        method: 'POST',
                        data: {
                            message: message
                        },
                        success: function() {
                            $('#message').val('');
                            fetchMessages();
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX error:", status, error);
                        }
                    });
                });
        
                // Fetch messages every 2 seconds
                setInterval(fetchMessages, 2000);
                fetchMessages();
            });
        </script>
