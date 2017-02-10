<?php
 session_start();
 include_once('dbconnect.php');
	
 $id=$_SESSION["uid"];
 $a=array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
 $b=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
 $c=array('0','1','2','3','4','5','6','7','8','9');
 $d=array('!','@','#','$','%','^','&');
 shuffle($a);
 shuffle($b);
 shuffle($c);
 shuffle($d);
 $res=$a[0];
 $res.=$b[0];
 $res.=$c[0];
 $res.=$d[0];
 $res.=$a[1];
 $res.=$a[2];
 $res.=$a[3];
 $res.=$a[4];
 
 $query="SELECT dept_id FROM jts__t_dept WHERE dept_name='".$_POST["dept_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r=$row["dept_id"];
 //print $r;
 $query="INSERT INTO  jts__t_users  (user_id,user_name,gender,email,mobile_no,ext_no,domain,password,dept_id,created_on,created_by,updated_on,updated_by,act) 
 VALUES('".$_POST["user_id"]."','".$_POST["user_name"]."','".$_POST["gender"]."','".$_POST["email"]."','".$_POST["mobile_no"]."','".$_POST["ext_no"]."','".$_POST["domain"]."','$res','$r',NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."','".$_POST['act']."')";
 $data=mysql_query($query);
 //$id=mysql_insert_id($conn);
 
 if($_POST["user_id"]){
	$arr=explode(',',trim($_POST['role_name'],','));
	foreach($arr as $k=>$v){
		$query="SELECT role_id FROM jts__t_roles WHERE role_name='$v'";
		$data1=mysql_query($query);
		$row1=mysql_fetch_array($data1);
		$r1=$row1["role_id"];
		$query="INSERT INTO jts__t_user_role(user_id,role_id,created_on,created_by,updated_on,updated_by,act)
		VALUES('".$_POST["user_id"]."','$r1',NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."','".$_POST['act']."')";
        $data=mysql_query($query);	
	}
	print $_POST["user_id"];
}else{
	print 0;
}
 ?>