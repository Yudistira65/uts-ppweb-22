<?php

require_once("../koneksi.php");

if(isset($_POST['btnsubmit'])){

    $btn = $_POST['btnsubmit'];

    $id_komik = isset($_POST['id_komik'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['id_komik'])):'';
    $judul = isset($_POST['judul'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['judul'])):'';
    $jumlah = isset($_POST['jumlah'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['jumlah'])):'';
    $harga_sewa = isset($_POST['harga_sewa'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['harga_sewa'])):'';

    $uploadOk = 1;
    $gambar = "";
    if($_FILES['gambar']['name']!=""){
        $target_dir = "../assets/img/";
        $gambar = $_FILES['gambar']['name'];
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $msg = "";
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if($check !== false) {
            $msg .= "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $msg .= "File is not an image.";
            $uploadOk = 0;
        }
        

        // Check if file already exists
        if (file_exists($target_file)) {
        $msg .= "Sorry, file already exists.";
        $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["gambar"]["size"] > 500000) {
        $msg .= "Sorry, your file is too large.";
        $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $msg .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        $msg .= "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["gambar"]["name"])). " has been uploaded.";
            } else {
            $msg .= "Sorry, there was an error uploading your file.";
            }
        }
        echo $msg;
    }

    if ($btn == "Tambah"){
        $sql = "INSERT INTO komik (judul, jumlah, harga_sewa, gambar) VALUES ('$judul', '$jumlah', '$harga_sewa', '$gambar')";
    
        if(mysqli_query($con, $sql)){
            notif("success","Data Telah Disimpan", "../index.php?p=komik");
        }else{
            notif("error", "Maaf Telah Terjadi Kesalahan", "../index.php?p=komik");
        }
    
    }else{
        $sql_gambar = ($gambar=="")?"":", gambar = '$gambar'";
        $sql = "UPDATE komik SET judul = '$judul', jumlah = '$jumlah', harga_sewa = '$harga_sewa'  $sql_gambar WHERE id_komik = '$id_komik' ";
        
        if(mysqli_query($con, $sql)){
            notif("success", "Data Telah Disimpan", "../index.php?p=komik");
        }else{
            notif("error", "Maaf Telah Terjadi Kesalahan", "../index.php?p=$id_komik");
        }
    }

}

?>