<?php
session_start();
include_once('dbconnect.php');
$query="SELECT DISTINCT a.* FROM jts__t_job_raised a JOIN jts__t_job_assigned b 
        WHERE b.user_id='".$_SESSION['uid']."' AND a.job_id=b.job_id AND b.state='Open'";
$data=mysql_query($query);
$cont="<div class='table-responsive'>";
$cont.="<h4 align='center'>SUPERVISOR'S PANEL</h4>";
$cont.="<table border=1 id='tbl_jobaction' class='table table-striped table-bordered table-hover'>";
$cont.="<tr>";
$cont.="<th>JOB ID</th>";
$cont.="<th>JOB DESCRIPTION</th>";
//$cont.="<th>STATUS</th>";
$cont.="<th>CHASSIS NO</th>";
$cont.="<th>VC NO</th>";
$cont.="<th>MODEL NO</th>";
$cont.="<th>REMARKS</th>";
$cont.="<th>TOTAL MAN HOURS</th>";
$cont.="<th>COMPLETION DATE</th>";
$cont.="<th>COMPLETION REMARKS</th>";
$cont.="<th>ACTION</th>";
$cont.="<th>REQUESTER NAME</th>";
$cont.="<th>REQUESTER DEPT.</th>";
$cont.="<th>REQUESTER EMAIL</th>";
$cont.="<th>REQUESTED DATE</th>";
$cont.="<th>EXPECTED COMPLETION DATE</th>";
$cont.="</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	$cont.= "<td align='center'>".$row["job_no"]."</td>";
	$cont.= "<td align='center'>".$row["job_name"]."</td>";
	//$cont.= "<td align='center'>".$row["sts_desc"]."</td>";
	$cont.= "<td align='center'>".$row["chassis_no"]."</td>";
	$cont.= "<td align='center'>".$row["vc_no"]."</td>";
	$cont.= "<td align='center'>".$row["model_no"]."</td>";
	$cont.= "<td align='center'>".$row["remark"]."</td>";
    $cont.="<td><input type='number' id='tmh' placeholder='TOTAL MAN HOURS' name='tot_hour'></td>";
	$cont.="<td><input type='date' id='cd' placeholder='COMPLETION DATE' name='comp_date'></td>";
	$cont.="<td><textarea placeholder='COMPLETION REMARKS' id='cr' name='comp_remark'></textarea></td>";
	$cont.= "<td align='center'><input type='button' data='".$row[job_id]."' data1='".$row[job_no]."' class='update btn btn-primary' value='Close'>";
	$cont.= "<input type='button' data='".$row[job_id]."' data1='".$row[job_no]."' class='cancel btn btn-danger' value='Cancel'></td>";
	$cont.= "<td align='center'>".$row["requester_name"]."</td>";
	$cont.= "<td align='center'>".$row["requester_dept"]."</td>";
	$cont.= "<td align='center'>".$row["requester_mail"]."</td>";
	$cont.= "<td align='center'>".$row["request_date"]."</td>";
	$cont.= "<td align='center'>".$row["expec_date"]."</td>";
    $cont.= "</tr>";	
}
$cont.="</table>";
$cont.="</div>";
print $cont;
?>
<html>
<body>
<script type="text/javascript" src="js/jquery-1.12.3.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
$('.cancel').click(function(){
	var con=confirm("Are you sure to cancel?");
		  if(con){
			  $('#tmh').val('');
			  $('#cd').val('');
			  $('#cr').val(''); 
		  } 
		  
});
$('.update').click(function(res){
	var id=$(this).attr('data1');
	var edit_tr1=$(this).closest('tr').find('td');
	var on1=edit_tr1.eq(6).find('#tmh').val();
	var os1=edit_tr1.eq(7).find('#cd').val();
	var ob1=edit_tr1.eq(8).find('#cr').val();
	if(on1=='' || os1=='' || ob1=='')
		alert("All fields are required");
	else
	{
	$.post('jobactadd.php',{
		'job_id':$(this).attr('data'),
		'tot_hour':on1,
		'comp_date':os1,
		'comp_remark':ob1,
	},function(res){
		if(res!=0)
	{       $('#tmh').val('');
		    $('#cd').val('');
			$('#cr').val('');
			alert('Job Closed');
			//alert(res);
		}
		else
		{
			alert('Error Occured');
		}
	});
	}
});
 </script>
</body>
</html>