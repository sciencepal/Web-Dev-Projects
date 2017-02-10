<?php 
 session_start();
 include_once('dbconnect.php');
 $query="SELECT user_id FROM jts__t_users WHERE user_name='".$_POST["user_name"]."'";
 $data=mysql_query($query);
 $row=mysql_fetch_array($data);
 $r=$row["user_id"];
 
 $query="INSERT INTO jts__t_job_assigned(job_id,user_id,est_time,time_unit,assigned_on,assigned_by,updated_on,
 updated_by,act,state) VALUES('".$_POST["job_id"]."','$r','".$_POST["est_time"]."','".$_POST["time_unit"]."',
 NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."','Active','Open')";
 $data=mysql_query($query);
 
 if($_POST["job_id"])
 {
	 $query="UPDATE jts__t_job_raised SET sts_id='2',updated_on=NOW(),updated_by='".$_SESSION['uid']."' WHERE job_id='".$_POST["job_id"]."'";
     $data=mysql_query($query);
	 $query="INSERT INTO jts__t_history(job_id,user_id,sts_id,created_on,created_by,updated_on,updated_by,act)
		VALUES('".$_POST["job_id"]."','$r','2',NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."','Active')";
	 $data=mysql_query($query);
	 print $_POST["job_id"];
}
 else
	 print 0;

?>