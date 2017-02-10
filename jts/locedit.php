<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 $query="UPDATE jts__t_loc  
 SET loc_name='".$_POST["loc_name"]."',updated_on=NOW(),updated_by='".$_SESSION['uid']."',act='".$_POST["act"]."'
 WHERE loc_id='".$_POST["loc_id"]."'";
 $data=mysql_query($query);
 if($_POST["loc_id"])
 {
	print $_POST["loc_id"];
 }
 else
 {
	print 0;
 }
 ?>