<?php
    error_reporting(0);
    include 'db.php';
	$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 2");
	$a = mysqli_fetch_object($kontak);
	
	$produk = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_id = '".$_GET['id']."' ");
	$p = mysqli_fetch_object($produk);

    $comnt = mysqli_query($conn, "SELECT * FROM tb_comment where image_id  = '".$_GET['id']."'");
	$c = mysqli_num_rows($comnt);   
	
	$like = mysqli_query($conn, "SELECT * FROM tb_like WHERE image_id = '".$_GET['id']."' ");
	$l = mysqli_num_rows($like);

    session_start();
	include 'db.php';
	if($_SESSION['status_login'] != true){
		echo '<script>window.location="login.php"</script>';
    }

    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>WEB Galeri Foto</title>
<link rel="stylesheet" href="fontAwesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>
    <!-- header -->
    <header>
        <div class="container">
        <h1><a href="dashboard.php" class="logo">WEB GALERI FOTO</a></h1>
        <ul>
           <li><a href="dashboard.php">Dashboard</a></li>
           <li><a href="profil.php">Profil</a></li>
           <li><a href="data-image.php">Data Foto</a></li>
           <li><a href="Keluar.php">Keluar</a></li>
        </ul>
        </div>
    </header>
    
    <!-- search -->
    <div class="search">
        <div class="container">
            <form action="galeri.php">
                <input type="text" name="search" placeholder="Cari Foto" value="<?php echo $_GET['search'] ?>" />
                <input type="hidden" name="kat" value="<?php echo $_GET['kat'] ?>" />
               <input type="submit" name="cari" value="Cari Foto" />
            </form>
        </div>
    </div>
    
    <!-- product detail -->
    <div class="section">
        <div class="container">
             <h3>Detail Foto</h3>
            <div class="box">
                <div class="col-2">
                   <img src="foto/<?php echo $p->image ?>" width="100%" /> 
                    
                    
                </div>
                <div class="col-2">
                   <h3><?php echo $p->image_name ?><br />Kategori : <?php echo $p->category_name  ?></h3>
                   <h4>Nama User : <?php echo $p->admin_name ?><br />
                   Upload Pada Tanggal : <?php echo $p->date_created  ?></h4>
                   <p>Deskripsi :<br />
                        <?php echo $p->image_description ?>
                   </p>
                  
                   <div class="col-2">
                   <div class="like">
                <!-------suka----->
                <?php
			   $idl = $_GET['id'];
			   $cekl = mysqli_query($conn, "SELECT * FROM tb_like WHERE image_id = '$idl' ");
			   if(mysqli_num_rows($cekl)){
				   while($ckl = mysqli_fetch_array($cekl)){
					   ?>
                       <?php if($_SESSION['id'] == $ckl['admin_id']){
						?>   
                <form method="post" action="" class="like">
                <input type="hidden" name="image_id" value="<?php echo $p->image_id ?>" />
                <input type="hidden" name="admin_id" value="<?php echo $_SESSION['a_global']->admin_id ?>" required />
                <input type="hidden" name="admin_name" value="<?php echo $_SESSION['a_global']->admin_name ?>" required />
                <button type="submit" name="like" id="button"><img src="img/jempol.png" width="50px" style="margin-bottom:5px;" /><h3>Like<?php echo $l ?></h3> </button>
                </form>
                
                <?php } ?>
                <?php }}?>
                
                <form method="post" action="" class="like">
                <input type="hidden" name="image_id" value="<?php echo $p->image_id ?>" />
                <input type="hidden" name="admin_id" value="<?php echo $_SESSION['a_global']->admin_id ?>" required />
                <input type="hidden" name="admin_name" value="<?php echo $_SESSION['a_global']->admin_name ?>" required />
                <button type="submit" name="like" id="button"><img src="img/jempol.png" width="50px" style="margin-bottom:5px;" /><h3>Like<?php echo $l ?></h3> </button>
                </form>
                <?php
				
				if(isset($_POST['like'])) {
					
					include  'db.php';

					
					$image_id           = $_POST['image_id'];
					$admin_id         = $_POST['admin_id'];
					$admin_name         = $_POST['admin_name'];
					   
					    if($insert){                                
                                echo '<script>window.location="detail-image_l.php?id='.$_GET['id'].'"</script>';
                        }else{
							  echo '<script>alert("Login Terlebih Dahulu")</script>';
							  echo '<script>window.location="login.php"</script>';
                              echo 'gagal'.mysqli_error($conn);
                                }
					   }
			   ?>
               </div>
               </div>
  
  
                </div>
                <div class="komen">
                <form action="" method="POST">
                    
                    <input type="hidden" name="imgid" value="<?php echo $p->image_id ?>">
                    <input type="hidden" name="adminid" value="<?php echo $_SESSION['a_global']->admin_id ?>">
                    <input type="hidden" name="adminn"  value="<?php echo $_SESSION['a_global']->admin_name ?>">
                    <textarea class="input-control" name="isi" placeholder="isi komen" required></textarea><br />
                <input type="submit" name="submit" value="Submit" class="btn">
            </form>
            <?php
                   if(isset($_POST['submit'])){
                    include 'db.php';
                    
					   
					   $idi = $_POST['imgid'];
                       $ida = $_POST['adminid'];
                       $name = $_POST['adminn'];
					   $isi = $_POST['isi'];
					   
					   $insert = mysqli_query($conn, "INSERT INTO tb_comment VALUES (
					                        null,
											
											'".$idi."',
                                            '".$ida."',
                                            '".$name."',
											'".$isi."',
                                            null
                                            ) ");
                                              
                             if($insert){                                
                                echo '<script>window.location="detail-image_l.php?id='.$_GET['id'].'"</script>';
                                 }else{
									echo '<script>alert("Login Terlebih Dahulu")</script>';
							  echo '<script>window.location="login.php"</script>'; 
                                    echo 'gagal'.mysqli_error($conn);
                                }
					   }
			   ?>
           
                          
                <div class="section">
                <h2> komentar <?php echo $c?></h2>
               
                <div class="box-comment">
            
                <?php
                    $id = $_GET['id'];
                    $comment = mysqli_query($conn, "SELECT * FROM tb_comment WHERE image_id ='$id' ORDER BY tanggal_komentar DESC");
					if(mysqli_num_rows($comment) > 0){
						while($k = mysqli_fetch_array($comment)){
				?>      
                        <div class="col-6">
                        
                        <h4><?php echo $k['admin_name'] ?></h4>
                        <h6><?php echo $k['tanggal_komentar'] ?></h6>
                        <p><?php echo $k['isi_comment'] ?></p>
                        
                        </div>
                        <br>
                    </a>
                <?php }}else{ ?>
                     <p>tidak ada komentar</p>
                <?php } ?>
            </div>
            </div>
        </div>
    </div>
                   
                </div>
            </div>
        </div>
    </div>
    
    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2024 - anti apriani.</small>
        </div>
    </footer>
</body>
 
</html>