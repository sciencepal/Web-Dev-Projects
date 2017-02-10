<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 
 $query="SELECT role_id FROM jts__t_roles WHERE role_name='".$_POST["role_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r=$row["role_id"];
  print $r;
 $query="SELECT menu_id FROM jts__t_menu WHERE menu_name='".$_POST["menu_name"]."'";
 $data=mysql_query($query);
 //print $data;
 $row1=mysql_fetch_array($data);
 $r1=$row1["menu_id"];
 
 $query="INSERT INTO  jts__t_role_menu  (role_id,menu_id,created_on,created_by,updated_on,updated_by,act) 
 VALUES('$r','$r1',NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."','".$_POST["act"]."')";
 $data=mysql_query($query);
 //$id=mysql_insert_id($conn);
 
 if($row1["role_id"])
 {
    print $row1["role_id"];
 }
 else
 {
   print 0;
}
 ?>