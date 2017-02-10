<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 $query="SELECT plant_id FROM jts__t_plant WHERE plant_name='".$_POST["plant_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r=$row["plant_id"];
 
 $query="INSERT INTO  jts__t_dept  (plant_id,dept_name,created_on,created_by,updated_on,updated_by,act) 
 VALUES('$r','".$_POST["dept_name"]."',NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."','Active')";
 $data=mysql_query($query);
 $id=mysql_insert_id($conn);
if($id){
	print $id;
}else{
	print 0;
}
 ?>