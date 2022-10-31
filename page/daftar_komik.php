 <?php 
 if(isset($_GET['detail'])):
    $id_komik = isset($_GET['detail'])?mysqli_real_escape_string($con, htmlspecialchars($_GET['detail'])):'';
 $sql = "SELECT * FROM komik WHERE id_komik = '$id_komik' ";
        $q = mysqli_query($con, $sql);
        if(mysqli_num_rows($q) > 0){
          $row = mysqli_fetch_array($q);  
          $judul = $row['judul'];
          $jumlah = $row['jumlah'];
          $harga_sewa = $row['harga_sewa'];
          $gambar = $row['gambar'];    
        }else{
            echo '<script>error_msg("index.php?p=daftar_komik");</script>';
        }    
 ?>
<div class="row">
    <div class="col-md-4 mb-5 text-center">
        <img src="assets/img/<?= $gambar; ?>" alt="<?= $judul; ?>">
    </div>
    <div class = "col-md-8 mb-5">
    <h1><?= $judul; ?></h1>
    <p>jumlah : <?=$jumlah; ?></p>
    <p>harga sewa : Rp.<?= number_format($harga_sewa);?></p>
    <hr>
    <?php if(isset($_SESSION['username'])):?>
    <form action="">
        <div class ="row">
            <div class = "col">
                <input type="number" class="form-control" placeholder="jumlah sewa" name="jumlah_sewa" min= "1">
        </div>
        <div class="col">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-cart-plus"></i>
                tambah keranjang
            </button>
            </div>
        </div>
        </form>
        <? endif;?>
    </div>
</div>
    
<?php else:?>
    <!-- Call to Action-->
    <div class="card text-white bg-secondary my-5 py-4 text-center">
    <div class="card-body"><p class="text-white m-0">Berikut Adalah Daftar Buku Yang Kami Sewakan</p></div>
</div>
    <!-- Content Row-->
<div class="row gx-4 gx-lg-5" id="komik-box">
    <?php 
        $sql = "SELECT * FROM komik";
        $q = mysqli_query($con,$sql);
        while($row = mysqli_fetch_array($q)):
    ?>
    <div class="col-md-3 mb-5">
        <div class="card h-100 item-komik">
            <div class="card-body">
                <h2 class="card-title"><?=$row['judul'];?></h2>
                <img class="img-komik" src="assets/img/<?= $row['gambar'];?>" alt="<?=$row['judul'];?>" />
            </div>
            <div class="card-footer"><a class="btn btn-primary btn-sm" href="index.php?p=daftar_komik&detail=<?=$row['id_komik'];?>">More Info</a></div>
        </div>
    </div>
    <?php endwhile;?>
</div>
<?php endif;?>