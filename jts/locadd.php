<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 $query="INSERT INTO  jts__t_loc  (loc_name,created_on,created_by,updated_on,updated_by,act) 
 VALUES('".$_POST["loc_name"]."',NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."','Active')";
 $data=mysql_query($query);
 $id=mysql_insert_id($conn);
if($id){
	print $id;
}else{
	print 0;
}
 ?>