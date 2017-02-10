<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 //$d=CURDATE();
 $r=addslashes($_POST["menu_desc"]);
 $query="INSERT INTO  jts__t_menu  (menu_name,menu_desc,menu_url,created_on,created_by,updated_on,updated_by,act) 
 VALUES('".$_POST["menu_name"]."','".$r."','".$_POST["menu_url"]."',NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."','".$_POST['menu_stat']."')";
 $data=mysql_query($query);
 $id=mysql_insert_id($conn);
if($id){
	print $id;
}else{
	print 0;
}
 ?>