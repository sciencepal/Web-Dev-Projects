<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 $query="SELECT app_id FROM jts__t_app WHERE app_name='".$_POST["app_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r=$row["app_id"];
 
 $query="SELECT plant_id FROM jts__t_plant WHERE plant_name='".$_POST["plant_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r1=$row["plant_id"];
 
 $query="UPDATE jts__t_app_plant
         SET app_id='$r',plant_id='$r1',updated_on=NOW(),updated_by='".$_SESSION['uid']."',act='".$_POST["act"]."'
         WHERE plant_id='".$_POST["plant_id"]."' AND app_id='".$_POST["app_id"]."'";
 $data2=mysql_query($query);
  if($_POST["plant_id"])
 {
	print $_POST["plant_id"];
 }
 else
 {
	print 0;
 }
 ?>