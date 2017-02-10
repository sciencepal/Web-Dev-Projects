<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 $query="UPDATE jts__t_unit  
 SET unit_name='".$_POST["unit_name"]."',updated_on=NOW(),updated_by='".$_SESSION['uid']."',act='".$_POST["act"]."' 
 WHERE unit_id='".$_POST["unit_id"]."'";
 $data=mysql_query($query);
 if($_POST["unit_id"])
 {
	print $_POST["unit_id"];
 }
 else
 {
	print 0;
 }
 ?>