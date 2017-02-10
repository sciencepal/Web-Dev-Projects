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
 
 $query="INSERT INTO  jts__t_plant  (org_id,unit_id,loc_id,plant_name,created_on,created_by,updated_on,updated_by,act) 
 VALUES('$r','$r1','$r2','".$_POST["plant_name"]."',NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."','".$_POST['act']."')";
 $data=mysql_query($query);
 $id=mysql_insert_id($conn);
	  if($id){
		print $id;
	}
	else{
	print 0;
}
 ?>