<?php 
 session_start();
 include_once('dbconnect.php');
 
 $query="UPDATE jts__t_job_assigned
 SET tot_hour='".$_POST["tot_hour"]."',comp_date='".$_POST["comp_date"]."',comp_remark='".$_POST["comp_remark"]."',
 updated_on=NOW(),updated_by='".$_SESSION['uid']."',act='Inactive',state='Close'
 WHERE job_id='".$_POST["job_id"]."'";
 $data=mysql_query($query);
 
 $query="UPDATE jts__t_job_raised
 SET updated_on=NOW(),sts_id='3',updated_by='".$_SESSION['uid']."',act='Inactive'
 WHERE job_id='".$_POST["job_id"]."'";
 $data=mysql_query($query);
 
 $query="INSERT INTO jts__t_history
 (job_id,user_id,sts_id,created_on,created_by,updated_on,updated_by) VALUES
 ('".$_POST["job_id"]."','".$_SESSION["uid"]."','3',NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."',act='Inactive')";
 $data=mysql_query($query);
 
 if($_POST["job_id"])
 {
	 $query="SELECT requester_mail FROM jts__t_job_raised WHERE job_id='".$_POST["job_id"]."'";
	 $data=mysql_query($query);
	 $row=mysql_fetch_array($data);
	 $to=$row["requester_mail"];
	 $subject="JOB COMPLETED";
	 $body="We hereby inform you that the job proposed by you has been completely successfully\n";
	 $body.="JOB ID:".$_POST["job_no"];
	 mail($to,$subject,$body,$header,-f{$to});
	 print $_POST["job_id"];
	 exit;
 }
 else
 {
	 print 0;
	 exit;
 }
 ?>