<?php

require 'function.php'; // Ensure this file includes the dbConn function

if (isset($_GET['token'])) {
    $db = dbConn();
    $token = $db->real_escape_string($_GET['token']);

    // Verify the token
    $sql = "SELECT UserId FROM users WHERE token = '$token' AND is_verified = 0";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // Token is valid, mark the user as verified
        $row = $result->fetch_assoc();
        $userId = $row['UserId'];

        $updateSql = "UPDATE users SET is_verified = 1, token = NULL WHERE UserId = $userId";
        if ($db->query($updateSql) === TRUE) {
            echo "Your email has been verified! You can now access the dashboard.";
        } else {
            echo "Error: " . $updateSql . "<br>" . $db->error;
        }
    } else {
        echo "Invalid or expired token.";
    }

    $db->close();
} else {
    echo "No token provided.";
}
