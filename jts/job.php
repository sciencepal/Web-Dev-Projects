<?php
session_start();
include_once('dbconnect.php');
$query="SELECT a.*, b.sts_desc FROM jts__t_job_raised a JOIN jts__t_master_status b WHERE 
        a.sts_id=b.sts_id AND a.act='Active'";
$data=mysql_query($query);
$cont="<div class='table-responsive'>";
$cont.="<table border=1 id='tbl_job' class='table table-striped table-bordered table-hover'>";
$cont.="<tr>";
$cont.="<th>JOB ID</th>";
$cont.="<th>STATUS</th>";
$cont.="<th>CHASSIS NO</th>";
$cont.="<th>VC NO</th>";
$cont.="<th>MODEL NO</th>";
$cont.="<th>JOB DESCRIPTION</th>";
$cont.="<th>REQUESTER NAME</th>";
$cont.="<th>REQUESTER DEPT.</th>";
$cont.="<th>REQUESTER EMAIL</th>";
$cont.="<th>REQUESTED DATE</th>";
$cont.="<th>EXPECTED COMPLETION DATE</th>";
$cont.="<th>REMARKS</th>";

$cont.="</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	$cont.= "<td align='center'>".$row["job_no"]."</td>";
	$cont.= "<td align='center'>".$row["sts_desc"]."</td>";
	$cont.= "<td align='center'>".$row["chassis_no"]."</td>";
	$cont.= "<td align='center'>".$row["vc_no"]."</td>";
	$cont.= "<td align='center'>".$row["model_no"]."</td>";
	$cont.= "<td align='center'>".$row["job_name"]."</td>";
	$cont.= "<td align='center'>".$row["requester_name"]."</td>";
	$cont.= "<td align='center'>".$row["requester_dept"]."</td>";
	$cont.= "<td align='center'>".$row["requester_mail"]."</td>";
	$cont.= "<td align='center'>".$row["request_date"]."</td>";
	$cont.= "<td align='center'>".$row["expec_date"]."</td>";
	$cont.= "<td align='center'>".$row["remark"]."</td>";
    $cont.= "</tr>";	
}
$cont.="</table>";
$cont.="</div>";
?>
<html>
<body>
				      <h3 align='center'>RAISE JOB</h3><br/>
<div class="panel panel-default">
	<div class="panel-heading">
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" id="tabs">
			<li class="active"><a href="#profile" data-toggle="tab">View</a>
			</li>
			<li><a href="#details" data-toggle="tab">Add</a>
			</li>
		</ul>

		<!-- Tab panes -->

		<div class="tab-content">
			<div class="tab-pane fade in active" id="profile">
			    <?php print $cont; ?>
			</div>
			<!--div class="tab-pane fade" id="view">
			    <div class="row">
                    <div class="col-lg-6">
			            <div class="form-group">
						    
					</div>
				</div>
			</div>
			</div-->
			<div class="tab-pane fade" id="details">
				<div class="row">
                    <div class="col-lg-6">
			            <div class="form-group">
						 <h4>Enter the following details:</h4> 
						    <label>Job ID:</label>
                            <input class="form-control" name="job_no" id="ji" placeholder="Job ID"><br/>
							<label>Chassis Number:</label>
                            <input class="form-control" name="chassis_no" id="cn" placeholder="CHASSIS NO"><br/>
							<label>VC Number:</label>
							<input class="form-control" name="vc_no" id="vn" placeholder="VC Number"><br/>
							<label>Model Number:</label>
							<input class="form-control" name="model_no" id="mn" placeholder="Model Number"><br/>
							<label>Job Description:</label>
							<textarea class="form-control" name="job_name" id="jn" placeholder="Job Description"></textarea>
							<label>Requester Name:</label>
                            <input class="form-control" name="requester_name" id="rn" placeholder="Requester Name">
							<label>Requester Dept:</label>
                            <input class="form-control" name="requester_dept" id="rd" placeholder="Requester Dept">
							<label>Requester Mail:</label>
                            <input class="form-control" name="requester_mail" id="rm" placeholder="Requester Mail">
							<label>Requested Date:</label>
                            <input class="form-control" type="date" name="request_date" id="ro" placeholder="Requested Date">
							<label>Expected Completion Date:</label>
                            <input class="form-control" type="date" name="expec_date" id="ed" placeholder="Expected Date">
							<label>Job Generation Remarks:</label>
                            <textarea class="form-control" name="remark" id="rk" placeholder="Remark"></textarea>
							</br><input type="button" value="Add" class="add btn btn-primary">
						</div>   
					</div>
				</div>
			</div>
		</div>
	<!-- /.panel-body -->
</div>
<!-- /.panel -->

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