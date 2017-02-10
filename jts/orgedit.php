<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 $query="UPDATE jts__t_org  
 SET org_name='".$_POST["org_name"]."',updated_on=NOW(),updated_by='".$_SESSION['uid']."',act='".$_POST["act"]."'
 WHERE org_id='".$_POST["org_id"]."'";
 $data=mysql_query($query);
 if($_POST["org_id"])
 {
	print $_POST["org_id"];
 }
 else
 {
	print 0;
 }
 ?>