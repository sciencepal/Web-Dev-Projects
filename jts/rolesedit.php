<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 $query="UPDATE jts__t_roles  
 SET role_name='".$_POST["role_name"]."',role_desc='".$_POST["role_desc"]."',updated_on=NOW(),updated_by='".$_SESSION['uid']."',act='".$_POST["act"]."'
 WHERE role_id='".$_POST["role_id"]."'";
 $data=mysql_query($query);
 if($_POST["role_id"])
 {
	print $_POST["role_id"];
 }
 else
 {
	print 0;
 }
 ?>