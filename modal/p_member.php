<?php

require_once("../koneksi.php");

    if(isset($_POST['btnsubmit'])){

    $username = isset($_POST['username'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['username'])):'';
    $password = isset($_POST['password'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['password'])):'';
    $no_tlpn = isset($_POST['no_telpn'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['no_telpn'])):'';
    $level = isset($_POST['level'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['level'])):'';    
   
        $sql = "INSERT INTO member (username, password, no_telpn, level) VALUES ('$username', '$password', '$no_telpn', $level)";
    
        if(mysqli_query($con, $sql)){
            notif("success","Daftar berhasil", "../index.php?p=member");
        }else{
            notif("error", "Maaf Telah Terjadi Kesalahan", "../index.php?p=member");
        }
    
    

}

    if(isset($_POST['btnregister'])){

    $username = isset($_POST['username'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['username'])):'';
    $password = isset($_POST['password'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['password'])):'';
    $no_tlpn = isset($_POST['no_telpn'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['no_telpn'])):'';
   
   
        $sql = "INSERT INTO member (username, password, no_telpn, level) VALUES ('$username', '$password', '$no_telpn', 1)";
    
        if(mysqli_query($con, $sql)){
            notif("success","Daftar berhasil", "../index.php?");
        }else{
            notif("error", "Maaf Telah Terjadi Kesalahan", "../index.php?p=register");
        }
    
    

}
if (isset($_POST['btnlogin'])){
    $username = isset($_POST['username'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['username'])):'';
    $password = isset($_POST['password'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['password'])):'';
    
    $sql = "SELECT * FROM member WHERE username = '$username' AND password= '$password'";
    $q = mysqli_query($con, $sql);
    if(mysqli_num_rows($q) > 0){
    $row = mysqli_fetch_array($q);
    $_SESSION['username'] = $row['username'];
    $_SESSION['password'] = $row['password'];
    $_SESSION['level'] = $row['level'];
    notif("success", "login berhasil", "../index.php");    
    }else {
        notif("error", "login gagal", "../index.php");
    }
}
if (isset($_GET['logout'])){
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['level']);
    session_destroy();
    echo "<script>document.location='../index.php';</script>";
}

?>