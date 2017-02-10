<?php
session_start();
include_once('dbconnect.php');
$query="SELECT a.*, b.sts_desc FROM jts__t_job_raised a JOIN jts__t_master_status b WHERE 
        a.sts_id=b.sts_id AND a.sts_id='1' AND a.act='Active'";
$data=mysql_query($query);
$cont="<div class='table-responsive'>";
$cont.="<table border=1 id='tbl_job1' class='table table-striped table-bordered table-hover'>";
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
$cont.="<th>ACTION</th>";
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
	$cont.= "<td align='center'><input type='button' data='".$row[job_id]."' data1='".$row[job_no]."' class='demo_edit btn btn-primary' value='Assign'></td>";
    $cont.= "</tr>";	
}
$cont.="</table>";
$cont.="</div>";
?>
<html>
<body>
<h3 align='center'>Assign JOB</h3><br/>
<div class="panel panel-default">
	<div class="panel-heading">
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" id="tabs">
			<li class="active"><a href="#profile" data-toggle="tab">View</a>
			</li>
			<li><a href="#details" data-toggle="tab">Assign</a>
			</li>
		</ul>

		<!-- Tab panes -->

		<div class="tab-content">
			<div class="tab-pane fade in active" id="profile">
			<?php print $cont; ?>
			</div>
			<div class="tab-pane fade" id="details">
				<div class="row">
                    <div class="col-lg-6">
			            <div class="form-group">
						 <h4>Enter the following details for <span id="lbl_job"></span>:</h4> 
						 <form>
						    <label>Supervisor:</label>
                            <?php
								    include_once('dbconnect.php');
								    $query="SELECT role_id FROM jts__t_roles WHERE role_name='Supervisor'";
                                    $data=mysql_query($query);
									$row=mysql_fetch_array($data);
									$r=$row["role_id"];
									$query="SELECT a.user_name FROM jts__t_users a JOIN jts__t_user_role b 
									ON a.user_id=b.user_id WHERE b.role_id='$r'";
									$data=mysql_query($query);
									//$row=mysql_fetch_array($data);
									$cont3="<select class='form_control' name='user_name' id='un' class='un'>";
									while($row1=mysql_fetch_array($data))
										{
											$cont3.="<option value='".$row1['user_name']."'>".$row1['user_name']."</option>";
										}
									$cont3.="</select>";
								    print $cont3;
								  ?>
							    </br></br><label>Estimated Completion time:</label>
                                <input class="form-control" type='number' name='est_time' id='et' placeholder="Estimated Time" >
								</br><label>Unit:</label>
                                <select class="form-control" name='time_unit' id='ut'>
									<option>Hours</option>
									<option>Days</option>
								</select>
								</br><input type="button" value="Assign" class="add btn btn-primary">
								<input type="reset" value="Reset" class="reset btn btn-primary">
								</form>
						</div>   
					</div>
				</div>
			</div>
		</div>
	<!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>
<script type="text/javascript" src="js/jquery-1.12.3.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
$('.add').click(function(){

	if($("#un").val()=='' || $("#et").val()=='' || $("#ut").val()==''){
		alert("All fields are required!!!");
		return false;		
	}else{
		//alert($("#un").val());
		$.post("assignjobadd.php",{
			'user_name':$("#un").val(),
			'est_time':$("#et").val(),
			'time_unit':$("#ut").val(),
			'job_id':$(this).attr('data_id'),
			}
			,function(res){
				//alert(res);
				if(res!='0'){
					$("#un").val('');
					$("#et").val('');
					$("#ut").val('Hours');
					alert("Values Successfully Inserted!!");
					$.post("assjob.php",{},function(res){
					$('#section1').html(res);});
				}else{
					alert("An error occured.");
				}
			});		
	}

});
$('#tbl_job1').on('click','.demo_edit',function(){
	var id=$(this).attr('data');
	$('.add').attr('data_id',id);
	var idd=$(this).attr('data1');
	$('#tabs').find('a').eq(1).trigger('click');
	$('#lbl_job').html(idd);	
 });
 </script>
</body>
</html>