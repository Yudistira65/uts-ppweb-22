<?php

$con = mysqli_connect("localhost","root","","persewaan_komik");

if(mysqli_connect_errno()){
    echo "koneksi gagal";
    exit();
}


function notif($msg="", $url=""){
    echo "<script>";
    if($msg=="" && $url!=""){
        echo  "document.location='$url'; "; 

    }else if ($msg!=""&&$url==""){
        echo "alert('$msg'); ";
    }else{  
        echo "alert('$msg'); ";
        echo  "document.location='$url'; ";
    }
    echo "</script>";
}




?>