<?php
 session_start();
 include_once('dbconnect.php');
 switch($_REQUEST['action']){
	 case 'edit':
	 edit();
	 break;
	 case 'update':
	 update();
	 break;
	 
 }
 function update(){
	 
	 $query="UPDATE jts__t_users  
	 SET user_name='".$_POST["user_name"]."',ext_no='".$_POST["ext_no"]."',dept_id='".$_POST["dept_name"]."',domain='".$_POST["domain"]."',updated_on=NOW(),updated_by='".$_SESSION['uid']."',act='".$_POST["act"]."'
	 WHERE user_id='".$_POST["user_id"]."'";
	 
	 $data=mysql_query($query);
	 
	if($_POST["user_id"])
	 {
		 $query="DELETE FROM jts__t_user_role WHERE user_id='".$_POST["user_id"]."'";
		 $data=mysql_query($query);
	     $arr=explode(',',trim($_POST['role_id'],','));
		 
	    foreach($arr as $k=>$v){
			//$query="SELECT role_id FROM jts__t_roles WHERE role_name='$v'";
			//$data1=mysql_query($query);
			//$row1=mysql_fetch_array($data1);
			//$r1=$row1["role_id"];
			//print $v;
			$query="INSERT INTO jts__t_user_role(user_id,role_id,created_on,created_by,updated_on,updated_by,act)
			VALUES('".$_POST["user_id"]."','$v',NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."','".$_POST['act']."')";
			$data=mysql_query($query);	
		print $_POST["user_id"];
	 }
	 }
	 else
	 {
		print 0;
	 }
 }
 function edit(){
	 $res=array();
	 $sql="SELECT * FROM jts__t_users WHERE user_id=".$_REQUEST['id']." AND act='Active'";
	 $data=mysql_query($sql);
	 $row=mysql_fetch_array($data);
	 array_push($res,$row);
	 
	 $sql="SELECT a.role_id,b.role_name FROM jts__t_user_role a JOIN jts__t_roles b ON a.role_id=b.role_id WHERE a.user_id=".$_REQUEST['id']." AND a.act='Active' AND b.act='Active'";
	 $data=mysql_query($sql);
	 while($row=mysql_fetch_array($data)){
		$row1[]=$row;
	 }
	 array_push($res,$row1);
	$row1=array();
	 $sql="SELECT dept_id,dept_name FROM jts__t_dept WHERE act='Active'";
	 $data=mysql_query($sql);
	 while($row=mysql_fetch_array($data)){
		$row1[]=$row;
	 }
	 array_push($res,$row1);
	 $row1=array();
	 $sql="SELECT role_id,role_name FROM jts__t_roles WHERE act='Active'";
	 $data=mysql_query($sql);
	 while($row=mysql_fetch_array($data)){
		$row1[]=$row;
	 }
	 array_push($res,$row1);
	 
	 print json_encode($res);
	 
	 /*$id=$_SESSION["uid"];
	 $query="SELECT dept_id FROM jts__t_dept WHERE dept_name='".$_POST["dept_name"]."'";
	 $data=mysql_query($query);
	 $row=mysql_fetch_array($data);
	 $r=$row["dept_id"];
	 print_r($r);*/
 }
 ?>