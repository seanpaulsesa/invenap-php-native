<?php
session_start();
  include "config/koneksi.php";
  if(!empty($_SESSION['username'])){
    @$user = $_SESSION['username'];
    @$level = $_SESSION['level'];
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="ico/favicon.ico">

    <title>Fixed Top Navbar Example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar-fixed-top.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Aplikasi Inventaris</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <?php
              if(@$level == "1"){
                ?>
                <li><a href="?p=list_barang&halaman=1">Daftar Inventaris</a></li>
                <li><a href="?p=peminjaman">Peminjaman</a></li>
                <li><a href="?p=pengembalian">Pengembalian</a></li>
                <li><a href="?p=laporan">Laporan</a></li>
                <?php
              }
            ?>
            <?php
              if(@$level == "2"){
                ?>
                <li><a href="?p=peminjaman">Peminjaman</a></li>
                <li><a href="?p=pengembalian">Pengembalian</a></li>
                <?php
              }
            ?>
            <?php
              if(@$level == "3"){
                ?>
                <li><a href="?p=peminjaman1">Peminjaman</a></li>
                <?php
              }
            ?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php 
              if(!empty($user)){
                  ?>
                    <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $user?><span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="page/keluar.php">Keluar</a></li>
                  <?php
              }
            ?>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
        <?php
        if(!empty($_SESSION['username'])){
            $user = $_SESSION['username'];

        @$p = $_GET['p'];
        switch ($p) {
            case 'login':
                include "page/login.php";
                break;

            case 'list_barang':
                include "page/list_barang.php";
                break;
            
            case 'tambah_barang':
                include "page/tambah_barang.php";
                break;
            
            case 'peminjaman':
                include "page/peminjaman.php";
                break;

            case 'peminjaman1':
                include "page/peminjaman1.php";
                break;

            case 'pengembalian':
                include "page/pengembalian.php";
                break;
            
            case 'home':
                include "page/home.php";
                break;
            
            case 'detail_pengembalian':
                include "page/detail_pengembalian.php";
                break;
            
            case 'laporan':
                include "page/laporan.php";
                break;
            
            case 'edit_barang':
                include "page/edit_barang.php";
                break;

            case 'hapus':
                include "page/hapus_barang.php";
                break;
            
            default:
                include "page/login.php";
                break;
        }
        }else{
          include "page/login.php";
        }
        ?>
      <!-- Main component for a primary marketing message or call to action -->


    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
<script type="text/javascript">
  $(document).on('click', '#cetak', function(){
    var tgl_awal = $("#tgl_awal"). val();
    var tgl_sampai = $("#tgl_sampai"). val();
    window.open('page/cetak_laporan.php?tgl_awal='+tgl_awal+"&tgl_sampai="+tgl_sampai, '_blank');
  });
</script>
<?php include 'footer.php';?>
