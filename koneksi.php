<?php

session_start();
date_default_timezone_set("Asia/Jakarta");

$con = mysqli_connect("localhost","root","","persewaan_komik");

if(mysqli_connect_errno()){
    echo "koneksi gagal";
    exit();
}


function notif($type="", $msg="", $url=""){
    if(in_array($type,["success", "error"])){
        echo "<script>";
        if($msg=="" && $url!=""){
            echo  "document.location='$url'; "; 

        }else if ($msg!=""&&$url==""){
            $_SESSION['msg'] = ["type" => $type, "text"=> $msg]; 
        }else{
            $_SESSION['msg'] = ["type" => $type, "text"=> $msg];  
            echo  "document.location='$url'; ";
        }
    echo "</script>";
    }
}




?>