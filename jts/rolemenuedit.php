<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 $query="SELECT role_id FROM jts__t_roles WHERE role_name='".$_POST["role_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r=$row["role_id"];
 
 $query="SELECT menu_id FROM jts__t_menu WHERE menu_name='".$_POST["menu_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r1=$row["menu_id"];
 
 $query="UPDATE jts__t_role_menu
         SET role_id='$r',menu_id='$r1',updated_on=NOW(),updated_by='".$_SESSION['uid']."',act='".$_POST["act"]."'
         WHERE role_id='".$_POST["role_id"]."' AND menu_id='".$_POST["menu_id"]."'";
 $data2=mysql_query($query);
  if($_POST["role_id"])
 {
	print $_POST["role_id"];
 }
 else
 {
	print 0;
 }
 ?>