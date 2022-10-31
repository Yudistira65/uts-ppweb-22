<?php
    $title = "Daftar";
    if(isset($_GET['ket'])){
        $ket = $_GET['ket'];
        $title = ucfirst($ket);
        $username = "";
        $password = "";
        $no_telpn = "";
        $level = "";

    }
?>
<div class="card">
    <div class="card-header">
         <? $title; ?>member
    </div>
    <div class="card-body">
    <?php
            if(isset($_GET['ket'])):
        ?>
        <form action="modal/p_member.php" method ="POST" >
            <div class="mb-3">
                <label for="username" class="form-label">username</label>
                <input type="text" class="form-control" name="username" id="username" <?= $username!=""?"value='$username'readonly":"";?> reqired>
            
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">password</label>
                <input type="text" class="form-control" name="password" id="password"value="<?= $password;?> "reqired >
            
            </div>
            <div class="mb-3">
                <label for="no_telpn" class="form-label">no_telpn</label>
                <input type="number" class="form-control" name="no_telpn" id="no_telpn"value="<?=$no_telpn;?>"reqired >
            
            </div>
            <div class="mb-3">
                <label for="level" class="form-label">level</label>
                <select name="level" id="level" class= "form-control">
                    <option value="0">admin</option>
                    <option value="1">member</option>
                </select>
            </div>
            <input type="submit" name="btnsubmit" value="<?=$title;?>" class="btn btn-primary">
        </form>
        <?php else: ?>
        <a href="index.php?p=member&ket=tambah" class="btn btn-success">Tambah</a>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>username</th>
                    <th>no tlpn</th>
                    <th>level</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * from member";
                    $q = mysqli_query($con, $sql);
                    $i=0;
                    while($row = mysqli_fetch_array($q)):
                ?>
                <tr>
                    <td><?= ++$i;?></td>
                    <td><?= $row["username"];?></td>
                    <td><?= $row["no_telpn"];?></td>
                    <td><?= $row["level"]==0?"admin":"member";?></td>
                </tr>
                <?php
                endwhile;
                ?>
            </tbody>
        </table>
        <?php endif;?>
    </div>
</div>