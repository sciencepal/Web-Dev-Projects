<?php
 $lp=$_POST['password'];
 include_once('dbconnect.php');
 $query="SELECT * FROM jts__t_users WHERE user_id='".$_POST['user_id']."'";
 $data=mysql_query($query);
 $row1=mysql_fetch_array($data);
  if($row1["password"]==$lp)
  {
	 session_start();
	 $_SESSION['uid']=$_POST['user_id'];
	 print 1;exit;
    
  }
  else
  {
	 print 0;exit;
  }
  ?>