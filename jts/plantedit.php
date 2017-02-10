<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 $query="SELECT org_id FROM jts__t_org WHERE org_name='".$_POST["org_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r=$row["org_id"];
 
 $query="SELECT unit_id FROM jts__t_unit WHERE unit_name='".$_POST["unit_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r1=$row["unit_id"];
 
 $query="SELECT loc_id FROM jts__t_loc WHERE loc_name='".$_POST["loc_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r2=$row["loc_id"];
 
 $query="UPDATE jts__t_plant 
 SET org_id='$r',unit_id='$r1',loc_id='$r2',plant_name='".$_POST["plant_name"]."'
 ,updated_on=NOW(),updated_by='".$_SESSION['uid']."',act='".$_POST["act"]."' 
 WHERE plant_id='".$_POST["plant_id"]."'";
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