<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "fazztrack";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

   	//jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//Pengujian Apakah data akan diedit atau disimpan baru
		if($_GET['hal'] == "edit")
		{
			//Data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE produk set
											 	nama_produk = '$_POST[tnama]',
											 	keterangan = '$_POST[tket]',
												harga = '$_POST[tharga]',
											 	jumlah = '$_POST[tjum]'
											 WHERE nama_produk = '$_GET[nama]'
										   ");
			if($edit) //jika edit sukses
			{
				echo "<script>
						alert('Edit data suksess!');
						document.location='index.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Edit data GAGAL!!');
						document.location='index.php';
				     </script>";
			}
		}
		else
		{
			//Data akan disimpan Baru
			$simpan = mysqli_query($koneksi, "INSERT INTO produk (nama_produk, keterangan, harga, jumlah)
										  VALUES ('$_POST[tnama]', 
										  		 '$_POST[tket]', 
										  		 '$_POST[tharga]', 
										  		 '$_POST[tjum]')
										 ");
			if($simpan) //jika simpan sukses
			{
				echo "<script>
						alert('Simpan data suksess!');
						document.location='index.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Simpan data GAGAL!!');
						document.location='index.php';
				     </script>";
			}
            
		}


		
	}

    //pengujian jika tombol edit/hapus diklik
    if(isset($_GET['hal'])){
        if($_GET['hal']=="edit"){
            //Tampilkan Data yang akan diedit
			$data = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama_produk = '$_GET[nama]' ");
			if($data){
                $vnama = $data ['nama_produk'];
                $vket = $data ['keterangan'];
                $vharga = $data ['harga'];
                $vjum = $data ['jumlah'];
            }
        }else if ($_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE nama_produk = '$_GET[nama]' ");
			if($hapus){
				echo "<script>
						alert('Hapus Data Suksess!!');
						document.location='index.php';
				     </script>";
			}
		}
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD-Irhan</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">CRUD FAZZTRACK</h1>
        <h2 class="text-center">Irhan Mustofa</h2>   

        <div class="card mt-3">
            <div class="card-header bg-dark text-white">
                INPUT PRODUK
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Nama Produk</label>
                        <input type="text" name="tnama" class="form-control" placeholder="Masukkan Nama Produk" required>
                        <label for="">Keterangan</label>
                        <textarea name="tket" type="text" class="form-control" placeholder="Keterangan"></textarea>
                        <label for="">Harga</label>
                        <input type="text" name="tharga" class="form-control" placeholder="Masukkan Harga" required>
                        <label for="">Jumlah</label>
                        <input type="text" name="tjum" class="form-control" placeholder="Masukkan Jumlah" required>
                    </div>

                    <button type="submit" class="btn btn-success mt-3" name="bsimpan">Simpan</button>
                    <button type="reset" class="btn btn-warning mt-3" name="breset">Kosongkan</button>

                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                DAFTAR PRODUK
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Keterangan</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $no = 1;
                        $tampil = mysqli_query($koneksi, "SELECT *from produk order by nama_produk desc");
                        while($data = mysqli_fetch_array ($tampil)) :
                    ?>
                    <tr>
                        <td><?=$no++;?></td>
                        <td><?=$data['nama_produk']?></td>
                        <td><?=$data['keterangan']?></td>
                        <td><?=$data['harga']?></td>
                        <td><?=$data['jumlah']?></td>
                        <td>
                            <a href="index.php?hal=edit&nama=$data['nama_produk']?>" class="btn btn-primary">Edit</a>
                            <a href="index.php?hal=hapus&nama=<?=$data['nama_produk']?>" 
	    			            onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>
<script type="text/js" src="js/bootstrap.min.js"></script>
</body>
</html>