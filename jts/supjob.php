<?php
session_start();
include_once('dbconnect.php');
$query="SELECT a.*,b.* FROM jts__t_job_assigned a JOIN jts__t_job_raised b 
WHERE a.job_id=b.job_id AND a.job_id IN 
(SELECT job_id FROM jts__t_job_assigned 
WHERE act='Active' AND state='Open' AND assigned_by='".$_SESSION['uid']."')";
$data=mysql_query($query);
$cont="<div class='table-responsive'>";
$cont.="<h3 align='center'>VIEW JOBS ASSIGNED BY YOU</h3><br/>";
$cont.="<table border=1 id='tbl_supjob' class='table table-striped table-bordered table-hover'>";
$cont.="<tr>";
$cont.="<th>JOB ID</th>";
$cont.="<th>USER NAME</th>";
$cont.="<th>EXPECTED COMPLETION DATE</th>";
$cont.="<th>EXPECTED COMPLETION TIME</th>";
$cont.="<th>REMARKS</th>";
$cont.="</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	$cont.= "<td align='center'>".$row["job_no"]."</td>";
	$r=$row["user_id"];
	$query1="SELECT user_name FROM jts__t_users WHERE user_id='$r'";
	$data1=mysql_query($query1);
	$row1=mysql_fetch_array($data1);
	$cont.= "<td align='center'>".$row1["user_name"]."</td>";
	$cont.= "<td align='center'>".$row["expec_date"]."</td>";
	$cont.= "<td align='center'>".$row["est_time"].$row["time_unit"]."</td>";
	$cont.= "<td align='center'>".$row["remark"]."</td>";
    $cont.= "</tr>";	
}
$cont.="</table>";
$cont.="</div>";
print $cont;
?>
<script type="text/javascript" src="js/jquery-1.12.3.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
$('.add').click(function(){
	if($("#ji").val()=='' || $("#cn").val()=='' || $("#vn").val()=='' || $("#mn").val()==''
       || $("#rn").val()=='' || $("#rd").val()=='' || $("#rm").val()=='' || $("#ed").val()==''){
		alert("Empty fields are required!!!");
		return false;		
	}else{
		$.post("jobadd.php",{
			'job_no':$("#ji").val(),
			'chassis_no':$("#cn").val(),
			'vc_no':$("#vn").val(),
			'model_no':$("#mn").val(),
			'job_name':$("#jn").val(),
			'requester_name':$("#rn").val(),
			'requester_dept':$("#rd").val(),
			'requester_mail':$("#rm").val(),
			'request_date':$("#ro").val(),
			'expec_date':$("#ed").val(),
			'remark':$("#rk").val(),
			}
			,function(res){
				alert(res);
				if(res!='0'){
					$("#ji").val('');
					$("#cn").val('');
					$("#vn").val('');
					$("#mn").val('');
					$("#jn").val('');
					$("#rn").val('');
					$("#rd").val('');
					$("#rm").val('');
					$("#ro").val('');
					$("#ed").val('');
					$("#rk").val('');
					alert("Value Successfully Inserted!!");
				    $.post("job.php",{},function(res){
					$('#section1').html(res);});
				}else{
					alert("An error occured.");
				}
			});		
	}

});
 </script>
</body>
</html>