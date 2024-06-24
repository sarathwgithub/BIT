<?php

//Create Database Conection-------------------
function dbConn() {
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "bittest_2";

    $conn = new mysqli($server, $username, $password, $db);

    if ($conn->connect_error) {
        die("Database Error : " . $conn->connect_error);
    } else {
        return $conn;
    }
}

//End Database Conection-----------------------
//Data Clean------------------------------------------
function dataClean($data = null) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

//End Data Clean

function checkPermission($current_url = null, $userid = null) {
    $parsed_url = parse_url($current_url);
    $path = $parsed_url['path'];
    $file_name = basename($path, '.php');
    $folder_name = basename(dirname($path));

    $db = dbConn();
    $sql = "SELECT * FROM `user_modules`  um "
            . "INNER JOIN modules  m ON m.Id=um.ModuleId "
            . "WHERE um.UserId='$userid' AND m.Path='$folder_name' AND m.File='$file_name';";

    $result = $db->query($sql);

    if ($result->num_rows <= 0) {
        return false;
    } else {
        return true;
    }
}


function uploadFiles($files) {
     $messages = array();
    foreach ($files['name'] as $key => $filename) {
        $filetmp = $files['tmp_name'][$key];
        $filesize = $files['size'][$key];
        $fileerror = $files['error'][$key];

        $file_ext = explode('.', $filename);
        $file_ext = strtolower(end($file_ext));

        $allowed_ext = array('pdf', 'png', 'jpg', 'gif', 'jpeg');
        
        if (in_array($file_ext, $allowed_ext)) {
            if ($fileerror === 0) {
                if ($filesize <= 2097152) {
                    $file_name = uniqid('', true) . '.' . $file_ext;
                    $file_destination = '../uploads/' . $file_name;
                    move_uploaded_file($filetmp, $file_destination);
                    $messages[$key]['upload'] = true;
                    $messages[$key]['file'] = $file_name;
                }else {
                    $messages[$key]['upload'] = false;
                    $messages[$key]['size'] = "The file size is invalid for $filename";
                }
            } else {
                $messages[$key]['upload'] = false;
                $messages[$key]['uploading'] = "Error occurred while uploading $filename";
            }
        } else {
            $messages[$key]['upload'] = false;
            $messages[$key]['type'] = "Invalid file type for $filename";         
            
        }
    }
    return $messages;
}
