<?php
 session_start();
 include_once('dbconnect.php');
 $id=$_SESSION["uid"];

 $query="INSERT INTO jts__t_job_raised
 (job_no,job_name,chassis_no,vc_no,model_no,requester_name,requester_dept,requester_mail,
 request_date,expec_date,raised_on,raised_by,remark,sts_id,updated_on,updated_by,act)
 VALUES('".$_POST["job_no"]."','".$_POST["job_name"]."','".$_POST["chassis_no"]."',
 '".$_POST["vc_no"]."','".$_POST["model_no"]."','".$_POST["requester_name"]."',
 '".$_POST["requester_dept"]."','".$_POST["requester_mail"]."','".$_POST["request_date"]."',
 '".$_POST["expec_date"]."',NOW(),'$id','".$_POST["remark"]."','1',NOW(),'".$_SESSION['uid']."','Active')";
 $data=mysql_query($query);
 $id1=mysql_insert_id($conn);
 if($id1)
 {
	    $query="INSERT INTO jts__t_history(job_id,sts_id,created_on,created_by,updated_on,updated_by,act)
		VALUES('$id1','1',NOW(),'".$_SESSION['uid']."',NOW(),'".$_SESSION['uid']."','Active')";
		$data=mysql_query($query);
		$to=$_POST["requester_mail"];
		$subject="JOB RAISED";
		$body="We hereby inform you that the job proposed by you has been raised successfully\n";
		$body.="JOB ID:".$_POST["job_no"];
		mail($to,$subject,$body,$header,-f{$to});
		print $id;
 }
 else
 {
	print 0;
 }
 ?>