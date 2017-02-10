<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 $query="UPDATE jts__t_app  
 SET app_name='".$_POST["app_name"]."',app_desc='".$_POST["app_desc"]."',updated_on=NOW(),updated_by='".$_SESSION['uid']."',act='".$_POST["act"]."'
 WHERE app_id='".$_POST["app_id"]."'";
 $data=mysql_query($query);
 if($_POST["app_id"])
 {
	print $_POST["app_id"];
 }
 else
 {
	print 0;
 }
 ?>