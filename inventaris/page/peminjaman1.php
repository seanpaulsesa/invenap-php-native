<?php
    $sql = "SELECT max(id_peminjaman) as maxKode FROM peminjaman";
    $query = mysqli_query($koneksi, $sql);
    $data = mysqli_fetch_array($query);
    $id_peminjaman = $data['maxKode'];

    @$noUrut = (int) substr($id_peminjaman, 3,3);
    $noUrut++;

    $char = "PMJ";
    $kodePeminjaman = $char . sprintf("%03s", $noUrut);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>peminjaman</title>
</head>
<body>
    <!-- row start -->
    <div class="row">
        <h2><center>Peminjaman Inventaris</center></h2>
        <hr>
        <div class="col-lg-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Peminjaman</div>
                <div class="panel-body">
                    <form action="" method="post">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kode Peminjaman</label>
                                <input type="text" class="form-control" name="id_peminjaman" value="<?= $kodePeminjaman ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Pegawai</label>
                                <select class="form-control" name="id_pegawai" id="id_pegawai">
                                    <option value="" class="form-control">Nama Pegawai</option>
                                    <?php
                                        $sql_pegawai = "SELECT * FROM pegawai";
                                        $q_pegawai = mysqli_query($koneksi, $sql_pegawai);
                                        while ($pegawai = mysqli_fetch_array($q_pegawai)) {
                                            ?>
                                            <option value="<?= $pegawai['id_pegawai'] ?>"><?= $pegawai['nama_pegawai'] ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Pilih Barang</label>
                                <select class="form-control" name="id_inventaris" id="id_inventaris">
                                    <option value="" class="form-control">Nama Barang</option>
                                    <?php
                                        $sql_inventaris = "SELECT * FROM inventaris";
                                        $q_inventaris = mysqli_query($koneksi, $sql_inventaris);
                                        while ($inventaris = mysqli_fetch_array($q_inventaris)) {
                                            ?>
                                            <option value="<?= $inventaris['id_inventaris'] ?>"><?= $inventaris['nama'] ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah</label>
                                <input type="number" class="form-control" name="jumlah">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-md btn-primary" name="simpan">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                    if (isset($_POST['simpan'])) {
                        $id_peminjaman = $_POST['id_peminjaman'];
                        $id_pegawai = $_POST['id_pegawai'];
                        $id_inventaris = $_POST['id_inventaris'];
                        $jumlah = $_POST['jumlah'];

                        $sql_peminjaman = "INSERT INTO peminjaman SET 
                        id_peminjaman = '$id_peminjaman',
                        id_pegawai = '$id_pegawai',
                        status_peminjaman = '0'";

                        $query_input = mysqli_query($koneksi, $sql_peminjaman);
                        if ($query_input) { 
                            $detail_pinjam = "INSERT INTO detail_pinjam SET jumlah = '$jumlah', id_inventaris = '$id_inventaris', id_peminjaman = 
                            '$id_peminjaman'";
                            $q_detail_pinjam = mysqli_query($koneksi, $detail_pinjam);
                            if ($q_detail_pinjam) {
                                ?>
                                    <script type="text/javascript">
                                        window.location.href="?p=peminjaman1"
                                    </script>
                                <?php
                            } else {
                                echo "Gagal";
                            }
                        }else {
                            echo "Gagal Menyimpan";
                        }
                    }
                ?>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="panel panel-primary">
                <div class="panel-heading">Daftar Barang DIPinjam</div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pinjam</th>
                                <th>Tgl.Pinjam</th>
                                <th>Nama Peminjam</th>
                                <th>Nama Barang</th>
                                <th>Jml</th>
                                <th>Tgl.Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $hari = date('d-m-Y');
                            $d_peminjaman = "SELECT *, detail_pinjam.jumlah as jml FROM detail_pinjam 
                                            LEFT JOIN peminjaman ON peminjaman.id_peminjaman = detail_pinjam.id_peminjaman 
                                            LEFT JOIN inventaris ON inventaris.id_inventaris = detail_pinjam.id_inventaris
                                            LEFT JOIN pegawai ON pegawai.id_pegawai = peminjaman.id_pegawai";
                            $d_query = mysqli_query($koneksi, $d_peminjaman);
                            $cek = mysqli_num_rows($d_query);

                            if ($cek > 0) {
                                $no = 1;
                                while ($data_d = mysqli_fetch_array($d_query)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data_d['id_peminjaman']?></td>
                                        <td><?= $data_d['tanggal_pinjam'] ?></td>
                                        <td><?= $data_d['nama_pegawai']?></td>
                                        <td><?= $data_d['nama']?></td>
                                        <td><?= $data_d['jml']?></td>
                                        <td><?= $data_d['tanggal_kembali']?></td>
                                        <td>
                                            <?php
                                                if($data_d['status_peminjaman'] == '0'){
                                                    echo "<label class='label label-danger'>Konfimasi</label>";
                                                }else if($data_d['status_peminjaman'] == '1'){
                                                    echo "<label class='label label-warning'>Dipinjam</label>";
                                                }else{
                                                    echo "<label class='label label-success'>Dikembalikan</label>";
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    
                                }
                            }
                        ?>
                            <!-- <tr>
                                <td>1</td>
                                <td>PJM001</td>
                                <td>11-11-2023</td>
                                <td>Andika</td>
                                <td>Laptop</td>
                                <td>10</td>
                                <td>12-11-2023</td>
                                <td>
                                    <label for="" class="label label-danger">Belum</label>
                                </td>
                                <td>
                                    <a href="" class="btn btn-primary btn-sm">Proses</a>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- row end -->
</body>
</html>