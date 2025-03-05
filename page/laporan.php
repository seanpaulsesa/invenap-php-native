<?php
    $hari_ini = date('d-m-Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>laporan</title>
</head>
<body>
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Laporan Peminjaman Inventaris</div>
            <div class="panel-body">
                <form action="" class="form-inline">
                    <input type="hidden" name="p" value="laporan">
                    <div class="form-group">
                        <label for="">Tanggal Awal</label><br>
                        <input type="date" name="tglDari" id="tgl_awal" class="form-control" value="<?= !empty($_GET['tglDari']) ? $_GET['tglDari'] : $hari_ini ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Sampai</label><br>
                        <input type="date" name="tglSampai" id="tgl_sampai" class="form-control" value="<?= !empty($_GET['tglSampai']) ? $_GET['tglSampai'] : $hari_ini ?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="cari" id="btnFilter" class="btn btn-sm btn-primary" value="Filter">
                        <button class="btn btn-sm btn-success" id="cetak">Cetak Laporan</button>
                    </div>
                </form>
                <br>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Nama Inventaris</th>
                            <th>Jumlah</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $cari ='';
                            @$tglDari = $_GET['tglDari'];
                            @$tglSampai = $_GET['tglSampai'];

                            if(!empty($tglDari)){
                                $cari .= "and tanggal_pinjam >='".$tglDari."'";
                            }
                            if(!empty($tglSampai)){
                                $cari .= "and tanggal_pinjam >='".$tglSampai."'";
                            }
                            // if(empty($tglDari) && empty($tglSampai)){
                            //     $cari .= "and tanggal_pinjam >='".$tglDari."'and tanggal_pinjam >='".$tglSampai."'";
                            // }

                            $sql = "SELECT *, detail_pinjam.jumlah as jml FROM detail_pinjam 
                                    LEFT JOIN peminjaman ON peminjaman.id_peminjaman = detail_pinjam.id_peminjaman 
                                    LEFT JOIN inventaris ON inventaris.id_inventaris = detail_pinjam.id_inventaris
                                    LEFT JOIN pegawai ON pegawai.id_pegawai = peminjaman.id_pegawai WHERE 1=1 $cari";

                            $query = mysqli_query($koneksi, $sql);
                            $cek = mysqli_num_rows($query);

                            if($cek > 0){
                                $no = 1;
                                while($data = mysqli_fetch_array($query)){
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['nama_pegawai'] ?></td>
                                            <td><?= $data['nama'] ?></td>
                                            <td><?= $data['jml'] ?></td>
                                            <td><?= $data['tanggal_pinjam'] ?></td>
                                            <td><?= $data['tanggal_kembali'] ?></td>
                                        </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                    <tr>
                                        <td colspan="6">Tidak Ada Data</td>
                                    </tr>
                                <?php
                            }
                        ?>
                        <!-- <tr>
                            <td>1</td>
                            <td>Suleman</td>
                            <td>Laptop</td>
                            <td>102</td>
                            <td>12-12-2023</td>
                            <td>13-12-2023</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>