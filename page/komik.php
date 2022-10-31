<?php
    $title = "Daftar";
    if(isset($_GET['ket'])){
        $ket = $_GET['ket'];
        $title = ucfirst($ket);
        $id_komik = "";
        $judul = "";
        $jumlah = 0;
        $harga_sewa = 0;
        $gambar = "";

        if($ket== "ubah"){
            $id_komik = isset($_GET['id'])?mysqli_real_escape_string($con, htmlspecialchars($_GET['id'])):'';
        $sql = "SELECT * FROM komik WHERE id_komik = '$id_komik' ";
        $q = mysqli_query($con, $sql);
        if(mysqli_num_rows($q) > 0){
          $row = mysqli_fetch_array($q);  
          $judul = $row['judul'];
          $jumlah = $row['jumlah'];
          $harga_sewa = $row['harga_sewa'];
          $gambar = $row['gambar'];    
        }else{
            echo '<script>error_msg("index.php?p=komik");</script>';
        }    
        }else if($ket== "hapus"){
            $id_komik = isset($_GET['id'])?mysqli_real_escape_string($con, htmlspecialchars($_GET['id'])):'';
            $sql = "DELETE FROM komik WHERE id_komik = '$id_komik'";
            if(mysqli_query($con, $sql)){
                echo '<script>success_msg("index.php?p=komik");</script>';
            }else{
                echo '<script>errors_msg("index.php?p=komik");</script>';  
            }
        }

    }
?>
<div class="card">
    <div class="card-header">
         <?= $title; ?> Komik
    </div>
    <div class="card-body">
        <?php
            if(isset($_GET['ket'])):
        ?>
        <form action="modal/p_komik.php" method ="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_komik" value="<?= $id_komik; ?>">
            <div class="mb-3">
                <label for="judul" class="form-label">judul</label>
                <input type="text" class="form-control" name="judul" id="judul"value="<?=$judul;?>" required>
            
            </div>
            <div class="mb-3">
                <label for="judul" class="form-label">jumlah</label>
                <input type="number" class="form-control" name="jumlah" id="jumlah"value="<?=$jumlah;?>"required min = "1">
            
            </div>
            <div class="mb-3">
                <label for="judul" class="form-label">harga_sewa</label>
                <input type="number" class="form-control" name="harga_sewa" id="harga_sewa"value="<?=$harga_sewa;?>"required min = "1">
            
            </div>
            <div class="mb-3">
                <label for="judul" class="form-label">gambar</label>
                <input type="file" class="form-control" name="gambar" id="gambar">
            
            </div>
            <input type="submit" name="btnsubmit" value="<?=$title;?>" class="btn btn-primary">
        </form>
        <?php else: ?>
        <a href="index.php?p=komik&ket=tambah" class="btn btn-success">Tambah</a>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Jumlah</th>
                    <th>Harga Sewa</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * from komik";
                    $q = mysqli_query($con, $sql);
                    $i=0;
                    while($row = mysqli_fetch_array($q)):
                ?>
                <tr>
                    <td><?= ++$i;?></td>
                    <td><?= $row["judul"];?></td>
                    <td><?= $row["jumlah"];?></td>
                    <td>Rp.<?= number_format($row["harga_sewa"]);?></td>
                    <td><img class ="img-komik-tbl"src="assets/img/<?= $row["gambar"];?>" alt="<?= $row["judul"];?>"></td>
                    <td>
                        <a href="index.php?p=komik&ket=ubah&id=<?= $row["id_komik"];?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                        <a href="index.php?p=komik&ket=hapus&id=<?= $row["id_komik"];?>" class="btn btn-danger btn-sm btn-hapus"><i class="fa fa-trash"></i></a>
                    </td>

                </tr>
                <?php
                endwhile;
                ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

