<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 
 $query="SELECT plant_id FROM jts__t_plant WHERE plant_name='".$_POST["plant_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r=$row["plant_id"];
 
 $query="UPDATE jts__t_dept  
 SET plant_id='$r',dept_name='".$_POST["dept_name"]."',updated_on=NOW(),updated_by='".$_SESSION['uid']."',act='".$_POST["act"]."'
 WHERE dept_id='".$_POST["dept_id"]."'";
 $data=mysql_query($query);
  if($_POST["plant_id"])
 {
	print $_POST["plant_id"];
 }
 else
 {
	print 0;
 }
 ?>