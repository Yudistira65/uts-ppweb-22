<?php
require_once("koneksi.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>UTS PPWEB 22</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="assets/css/styles.css?t=<?= time(); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            function error_msg(url="", msg=""){
                if(msg==""){
                    msg= "'Something went wrong!";
                }
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: msg,
        }).then((result)=> {
            if(url!=""){
            document.location=url;
        }
        });
        }
            function success_msg(url="", msg=""){
                if(msg==""){
                    msg= "good job!";
                }
            Swal.fire({
            icon: 'success',
            title: 'success',
            text: msg,
        }).then((result)=> {
            if(url!=""){
            document.location=url;
        }
        });
    }
        function delete_msg(url){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    document.location=url;
                }
            });
        }
        
        </script> 
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="index.php">SKY</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                        <?php if(isset($_SESSION['username'])):?>
                            <?php if($_SESSION['level']==0):?>
                        <li class="nav-item"><a class="nav-link" href="index.php?p=komik">komik</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?p=member">member</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="index.php?p=komik">komik</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php">transaksi</a></li>
                        <?php endif;?>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="index.php?p=daftar_komik">komik</a></li>
                        <?php endif;?>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                                if (isset($_SESSION['username'])){
                                    echo $_SESSION['username'];
                                }else{
                                    echo "member";
                                }
                                ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if(isset($_SESSION['username'])):?>
                                <li><a class="dropdown-item" href="index.php">keranjang</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="modal/p_member.php?logout">logout</a></li>
                                <?php else:?>
                                <li><a class="dropdown-item" href="index.php?p=login">login</a></li>
                                <li><a class="dropdown-item" href="index.php?p=register">register</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page Content-->
        <div class="container px-4 px-lg-5 container-main" >
            <?php
                $pages = scandir("page");
                if (isset($_GET['p'])){
                    $p = $_GET['p'].".php";
                    if (in_array($p, $pages)){
                        include "page/$p";
                    }else{
                        echo "<h1>page not found</h1>";
                    }
                }else{
                    include 'page/home.php';
                }
                ?>

        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">SKY</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="assets/js/scripts.js"></script>
        <script>
            $(document).ready(function(){
            $(".btn-hapus").click(function(e){
                e.preventDefault();
                let url = $(this).attr("href");
                delete_msg(url);
            });    
            });

            <?php
                if(isset($_SESSION['msg'])){
                    $msg = $_SESSION['msg']['type'];
                    $text = isset($_SESSION ['msg']['text'])?$_SESSION["msg"]["text"]:"";
                    $url = isset($_SESSION ['msg']['url'])?$_SESSION["msg"]["url"]:"";
                    if($msg == "success"){
                        echo "success_msg('$url','$text');";
                    }else{
                        echo "error_msg('$url','$text');";
                    }
                    unset($_SESSION['msg']);
                    
                }
                ?>

        </script>
    </body>
</html>
