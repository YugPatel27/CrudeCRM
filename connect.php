<?php
function connectdb(){
    $host = "localhost";
    $user = "root";
    $pwd =  "";
    $db = "crmcrude";
    $con = mysqli_connect($host, $user, $pwd, $db);
    if(!$con){
          echo "connection error";
    }
    else{     
    return $con;
    }
}

function log_activity($conn, $user_id, $module, $action) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, module, action, ip_address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $module, $action, $ip);
    $stmt->execute();
}
?>