<?php

require_once("../koneksi.php");

if(isset($_POST['btnaddcart'])){
    
    $id_komik = isset($_POST['id_komik'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['id_komik'])):'';
    $jumlah = isset($_POST['jumlah_sewa'])?mysqli_real_escape_string($con, htmlspecialchars($_POST['jumlah_sewa'])):0;
    
    $sql = "SELECT * FROM komik WHERE id_komik = '$id_komik' ";
    $q = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($q);
    
    if($jumlah > $row['jumlah']){
        notif("error", "Jumlah Sewa melebihi stok!", "../index.php?p=daftar_komik&id=$id_komik");
    }
    
    $data_cart[$id_komik] = [
        "username" => $_SESSION['username'],
        "id_komik" => $id_komik,
        "judul" => $row['judul'],
        "harga_sewa" => $row['harga_sewa'],
        "gambar" => $row['gambar'],
        "stok" => $row['jumlah'],
        "jumlah" => $jumlah,
    ];

    
    if(!isset($_COOKIE['cart_'.$_SESSION['username']])){
        isicookie("cart_".$_SESSION['username'], json_encode($data_cart), 3600);
    }else{
        $cart = json_decode($_COOKIE['cart_'.$_SESSION['username']], true);
        $ada = false;
        foreach($cart as $k => $v){
            if($id_komik == $k){
                $cart[$k]["jumlah"] += $jumlah;
                $ada = true;
            }
        }
        if(!$ada){
            $cart[$id_komik] = $data_cart[$id_komik];
        }
        isicookie("cart_".$_SESSION['username'], json_encode($cart), 3600);
    }
    notif("success", "Komik berhasil ditambahkan ke keranjang!", "../index.php?p=keranjang");
}

if(isset($_POST['checkout'])){
    $id_transaksi = "T".date("YmdHis");
    $username = $_SESSION['username'];
    $tgl_sewa = date("Y-m-d H:i:s");
    $total_pembayaran = 0;
    $sql_detail = [];
    foreach($_POST['id_komik'] as $k => $v){
        $id_komik = $v;
        $jumlah = isset($_POST['jumlah'][$k])?mysqli_real_escape_string($con, htmlspecialchars($_POST['jumlah'][$k])):0;
        
        $sql = "SELECT * FROM komik WHERE id_komik = '$id_komik' ";
        $q = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($q);
        
        if($jumlah > $row['jumlah']){
            notif("error", "Jumlah Sewa melebihi stok!", "../index.php?p=daftar_komik&id=$id_komik");
        }
        $total_pembayaran += $row['harga_sewa'] * $jumlah;
        $stok_akhir = $row['jumlah'] - $jumlah;
        $sql = "INSERT INTO detail_sewa (id_transaksi, id_komik, jumlah) VALUES('$id_transaksi', '$id_komik', $jumlah);";
        $sql2 = "UPDATE komik SET jumlah = $stok_akhir WHERE id_komik = '$id_komik' ;";
        array_push($sql_detail, $sql);
        array_push($sql_detail, $sql2);
    }


    mysqli_begin_transaction($con);
    try{
        $sql = "INSERT INTO persewaan (id_transaksi, username , tgl_sewa, total_pembayaran) VALUES ('$id_transaksi', '$username', '$tgl_sewa', $total_pembayaran); ";
        mysqli_query($con, $sql);
        foreach($sql_detail as $k => $v){
            mysqli_query($con, $v);
        }
        mysqli_commit($con);
        isicookie("cart_".$_SESSION['username'], "", 0);
        notif("success", "Transaksi Berhasil!", "../?p=transaksi&id=$id_transaksi&new");
    } catch (mysqli_sql_exception $exception) {
        mysqli_rollback($con);
        notif("error", "Terjadi Kesalahan!", "../index.php?p=keranjang");
    }
    
}

if(isset($_GET['kembali'])){
    $id_transaksi = isset($_GET['id'])?mysqli_real_escape_string($con, htmlspecialchars($_GET['id'])):'';
    $tgl_kembali = date("Y-m-d H:i:s");
    
    mysqli_begin_transaction($con);
    
    try{
        $sql = "SELECT a.*, b.id_komik, b.judul, b.harga_sewa, b.gambar, b.jumlah AS stok  FROM detail_sewa a JOIN komik b ON a.id_komik = b.id_komik WHERE id_transaksi = '$id_transaksi' ";
        $q = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($q)){
            $stok_akhir = $row['jumlah'] + $row['stok'];
            $sql_update_komik = "UPDATE komik SET jumlah = $stok_akhir WHERE id_komik = '$row[id_komik]' ";
            mysqli_query($con, $sql_update_komik);
        }
        $sql_update = "UPDATE persewaan SET tgl_kembali = '$tgl_kembali' WHERE id_transaksi = '$id_transaksi' ";
        mysqli_query($con, $sql_update);
        mysqli_commit($con);
        notif("success", "Pengembalian Berhasil!", "../index.php?p=akun");
    } catch (mysqli_sql_exception $exception) {
        mysqli_rollback($con);
        notif("error", "Terjadi Kesalahan!", "../index.php?p=akun");
    }
}

?>