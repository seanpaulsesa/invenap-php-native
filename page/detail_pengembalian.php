<?php
    $id_peminjaman = $_GET['id_peminjaman'];
    if(empty($id_peminjaman)){
        ?>
            <script type="text/javascript">
                window.location.href ="?p=pengembalian";
            </script>
        <?php
    }
    $hari = date('d-m-Y');
    $d_peminjaman = "SELECT *, detail_pinjam.jumlah as jml FROM detail_pinjam 
                    LEFT JOIN peminjaman ON peminjaman.id_peminjaman = detail_pinjam.id_peminjaman 
                    LEFT JOIN inventaris ON inventaris.id_inventaris = detail_pinjam.id_inventaris
                    LEFT JOIN pegawai ON pegawai.id_pegawai = peminjaman.id_pegawai WHERE peminjaman.id_peminjaman=
                    '$id_peminjaman'";
    $d_query = mysqli_query($koneksi, $d_peminjaman);
    $data = mysqli_fetch_array($d_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengembalian</title>
</head>
<body>
    <div class="col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Konfirmasi Pengembalian Inventaris</div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="" class="">Kode Peminjaman</label>
                        <input type="text" name="id_peminjaman" id="" class="form-control" value="<?= $data['id_peminjaman']?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="">Tanggal Peminjaman</label>
                        <input type="text" name="tgl_pinjam" id="" class="form-control" value="<?= $hari ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="">Nama Peminjam</label>
                        <input type="text" name="nama_pegawai" id="" class="form-control" value="<?= $data['nama_pegawai']?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="">Nama Barang</label>
                        <input type="text" name="nama" id="" class="form-control" value="<?= $data['nama']?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="">Jumlah</label>
                        <input type="number" name="jml" id="" class="form-control" value="<?= $data['jml']?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="">Tanggal Pengembalian</label>
                        <input type="date" name="tgl_kembali" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-md" type="submit" name="simpan">Simpan</button>
                        <a href="?p=pengembalian" class="btn btn-md btn-default">Kembali</a>
                    </div>
                </form>
            </div>
            <?php
                if(isset($_POST['simpan'])){
                    $tgl_kembali = $_POST['tgl_kembali'];

                    $sql_pengembalian = "UPDATE peminjaman SET tanggal_kembali = '$tgl_kembali', status_peminjaman='2' WHERE id_peminjaman='$id_peminjaman'";
                    $q_pengembalian = mysqli_query($koneksi, $sql_pengembalian);

                    if($q_pengembalian){
                        ?>
                            <script type="text/javascript">
                                window.location.href="?p=pengembalian";
                            </script>
                        <?php
                    }else{
                        ?>
                            <div class="alert alert-danger">
                                Barang Gagal Untuk Diupdate!
                            </div>
                        <?php
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>