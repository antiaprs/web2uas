<?php

   include 'db.php';
      
   if(isset($_GET['idk'])){
	  

	  $delete = mysqli_query($conn, "DELETE FROM tb_comment WHERE comment_id = '".$_GET['idk']."' ");
	  echo '<script>window.location="dashboard.php"</script>';
   }

?>