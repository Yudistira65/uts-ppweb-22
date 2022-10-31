<div class="card">
    <div class="card-header">
         daftar member
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>username</th>
                    <th>no tlpn</th>
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
                    <td><?= $row["no_tlpn"];?></td>
                </tr>
                <?php
                endwhile;
                ?>
            </tbody>
        </table>
    </div>
</div>