<?php
 $a=$_POST["menu_name"];
 $b=$_POST["menu_desc"];
 $c=$_POST["menu_url"];
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];
 //$d=CURDATE();
 $query="INSERT INTO jts__t_menu(menu_name,menu_desc,menu_url,created_on,created_by,updated_on,updated_by) VALUES('$a','$b','$c','NOW()','$id'','NOW()','$id')";
 $data=mysql_query($query);
 echo "DATA SUCCESSFULLY UPDATED";
 ?>