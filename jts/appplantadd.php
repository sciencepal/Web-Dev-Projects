<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 
 $query="SELECT plant_id FROM jts__t_plant WHERE plant_name='".$_POST["plant_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r=$row["plant_id"];

 $query="SELECT app_id FROM jts__t_app WHERE app_name='".$_POST["app_name"]."'";
 $data=mysql_query($query);
 //print $data;
 $row1=mysql_fetch_array($data);
 $r1=$row1["app_id"];
 
 $query="INSERT INTO  jts__t_app_plant  (app_id,plant_id,created_on,created_by,updated_on,updated_by,act) 
 VALUES('$r1','$r',NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."','".$_POST["act"]."')";
 $data=mysql_query($query);
 //$id=mysql_insert_id($conn);
 
 if($row1["app_id"])
 {
    print $row1["app_id"];
 }
 else
 {
   print 0;
}
 ?>