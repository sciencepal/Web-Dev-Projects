<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 $query="UPDATE jts__t_menu  
         SET menu_name='".$_POST["menu_name"]."',menu_desc='".$_POST["menu_desc"]."',
		 menu_url='".$_POST["menu_url"]."',updated_on=NOW(),updated_by='".$_SESSION['uid']."',act='".$_POST["menu_stat"]."'
         WHERE menu_id='".$_POST["menu_id"]."'";
 $data=mysql_query($query);
 if($_POST["menu_id"])
 {
	print $_POST["menu_id"];
 }
 else
 {
	print 0;
 }
 ?>