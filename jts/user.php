<?php
session_start();
include_once('dbconnect.php');
$query="SELECT 
a.*,b.dept_name
FROM jts__t_users a JOIN jts__t_dept b ON a.dept_id=b.dept_id";
$data=mysql_query($query);
$cont="<div class='table-responsive'>";
$cont.="<table border=1 id='tbl_user' class='table table-striped table-bordered table-hover'>";
$cont.="<tr>";
//$cont.="<th>USER ID</th>";
$cont.="<th>USER NAME</th>";
$cont.="<th>GENDER</th>";
$cont.="<th>EMAIL</th>";
$cont.="<th>MOBILE_NO.</th>";
//$cont.="<th>EXTENSION NO.</th>";
//$cont.="<th>DOMAIN</th>";
//$cont.="<th>PASSWORD</th>";
$cont.="<th>DEPARTMENT NAME</th>";
$cont.="<th>STATE</th>";
$cont.="<th>ACTION</th>";
$cont.="</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	//$cont.= "<td align='center'>".$row["user_id"]."</td>";
	$cont.= "<td align='center'>".$row["user_name"]."</td>";
	$cont.= "<td align='center'>".$row["gender"]."</td>";
	$cont.= "<td align='center'>".$row["email"]."</td>";
	$cont.= "<td align='center'>".$row["mobile_no"]."</td>";
	//$cont.= "<td align='center'>".$row["ext_no"]."</td>";
	//$cont.= "<td align='center'>".$row["domain"]."</td>";
	//$cont.= "<td align='center'>".$row["password"]."</td>";
	$cont.= "<td align='center'>".$row["dept_name"]."</td>";
	$cont.= "<td align='center'>".$row["act"]."</td>";
	$cont.= "<td align='center'><input type='button' data='".$row[user_id]."' class='demo_edit btn btn-primary' value='Edit'></td>";
    $cont.= "</tr>";	
}
$cont.="</table>";
$cont.="</div>";
?>
				      <h3 align='center'>USERS</h3><br/>

<div class="panel panel-default">
	<div class="panel-heading">
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" id="tabs">
			<li class="active"><a href="#profile" data-toggle="tab">Profile</a>
			</li>
			<li><a href="#view" data-toggle="tab">Edit</a>
			</li>
			<li><a href="#details" data-toggle="tab">Add</a>
			</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane fade in active" id="profile">
				<?php print $cont;?>
			</div>
			<div class="tab-pane fade" id="view">
			    <div class="row">
                    <div class="col-lg-6">
			            <div  id="editdv" class="form-group">
						    
						</div>
					</div>
				</div>
			</div>
			
			<div class="tab-pane fade" id="details">
				<div class="row">
                    <div class="col-lg-6">
			            <div class="form-group">
						    <h4>Enter the following details:</h4> 
							<label>User Id:</label>
                            <input class="form-control" type='text' name='user_id' id='ui' placeholder="User Id">
							<label>User Name:</label>
                            <input class="form-control" type='text' name='user_name' id='un' placeholder="User Name">
							<label>Gender:</label>
                                <select class="form-control" name='gender' id='act2'>
									<option>Male</option>
									<option>Female</option>
								</select>
							<label>Email:</label>
                            <input class="form-control" type='text' name='email' id='em' placeholder="Email">
							<label>Mobile Number:</label>
                            <input class="form-control" type='number' name='mobile_no' id='mn' placeholder="Mobile Number">
							<label>Extension Number:</label>
                            <input class="form-control" type='text' name='ext_no' id='en' placeholder="Extension Number">
							<label>Domain:</label>
                            <input class="form-control" type='text' name='domain' id='dm' placeholder="Domain">
							<label>Department Name:</label><br>
                                 <?php
								    include_once('dbconnect.php');
								    $query="SELECT dept_name FROM jts__t_dept";
                                    $data=mysql_query($query);
									$cont3="<select class='form_control' name='dept_name' id='dn'>";
									while($row1=mysql_fetch_array($data))
										{
											$cont3.="<option value='".$row1['dept_name']."'>".$row1['dept_name']."</option>";
										}
									$cont3.="</select>";
								    print $cont3;
								  ?>
							<br>
							
							<!--label>Password:</label>
                            <input class="form-control" name='password' id='pw' type="password" placeholder="Password"-->
							 <label>Status</label>
								<select class="form-control" name='act' id='act1'>
									<option>Active</option>
									<option>Inactive</option>
								</select>
							<br>
							<label>Roles:</label><br>
                                 <?php
								    include_once('dbconnect.php');
								    $query="SELECT role_name FROM jts__t_roles";
                                    $data=mysql_query($query);
									$cont3="<select class='form_control' name='role_name' id='rn' class='rn'>";
									while($row1=mysql_fetch_array($data))
										{
											$cont3.="<option value='".$row1['role_name']."'>".$row1['role_name']."</option>";
										}
									$cont3.="</select>";
									$cont3.="<a href='javascript:void(0)' id='role_id'><span class='fa fa-plus'></span></a>";
								    print $cont3;
								  ?>
							<input type="hidden" value="" id="ass_role" />
							<div id="dv_ass_role"></div>
							<input type="button" value="Add" class="add btn btn-primary">
						</div>
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
	if($("#ui").val()=='' || $("#un").val()=='' || $("#act2").val()=='' ||$("#mn").val()=='' ||$("#pw").val()=='' || $("#dn").val()=='' ||$("#act1").val()==''){
		alert("USER ID,USER NAME,GENDER,MOBILE NO,PASSWORD,DEPARTMENT ID and STATE are required!!!");
		return false;		
	}else{
		$.post("useradd.php",{
			'user_id':$("#ui").val(),
			'user_name':$("#un").val(),
			'gender':$("#act2").val(),
			'email':$("#em").val(),
			'mobile_no':$("#mn").val(),
			'ext_no':$("#en").val(),
			'domain':$("#dm").val(),
			'dept_name':$("#dn").val(),
			'role_name':$("#ass_role").val(),
			'act':$("#act1").val()}
			,function(res){
				alert(res);
				if(res!='0'){
					$("#ui").val('');
					$("#un").val('');
					$("#act2").val('');
					$("#em").val('');
					$("#mn").val('');
					$("#en").val('');
					$("#dm").val('');
					//$("#pw").val('');
					$("#dn").val('');
					$("#act1").val('Active');
					alert("Value Successfully Inserted!!");
				}else{
					alert("An error occured.");
				}
			});		
	}

});
$('#tbl_user').on('click','.demo_edit',function(){
	var id=$(this).attr('data');
	$.post('useredit.php',{'id':id,'action':'edit'},function(res){
		
		var result=$.parseJSON(res);
		var arole=result.pop();
		var dept=result.pop();
		var role=result.pop();
		var user="<h4>Enter the following details:</h4>";
		
		$.each(result,function(i,item){
			user += '<label>User Name:</label>';
            user += '<input class="form-control" id="unm" value="'+item.user_name+'">';
			user += '<label>Extension Number:</label>';
			user += '<input class="form-control" id="exn" value="'+item.ext_no+'">';
			user += '<label>Domain:</label>';
			user += '<input class="form-control" id="dmn" value="'+item.domain+'">';
			user += '<label>Department Name:</label>';
			user += "<select class='form_control' name='dept_name' id='dnm'>";
			$.each(dept,function(it,ite){
				user += "<option value='"+ite.dept_id+"'>"+ite.dept_name+"</option>";
			});
			user +="</select><br/>";
			user +="<label>State</label>";
			user +='<select class="form-control"id="sts">';
			user +='<option value="Active">Active</option>';
			user +='<option value="Inactive">Inactive</option>';
			user +='</select>';
		});
		var hidden="";
		$.each(role,function(iim,iit){
			user+="<select id='rn_edit'>";
			$.each(arole,function(ai,ait){
				user+="<option value="+ait.role_id+">"+ait.role_name+"</option>";
			});
			hidden+=iit.role_id+',';
			user+="</select><a href='javascript:void(0)' id='role_id'><span class='fa fa-plus'></span></a>";
			user+='<input type="hidden" value="'+hidden+'" id="assgn_role" />';
			user+="<div id='edit_role_list'><div><span>"+iit.role_name+"<button class='remove_role_edit fa fa-minus' href='javascript:void(0);' style='color:red; boder:2px solid green;' data_remove='"+iit.role_id+"'></button></span></div></div>";
		});
		user +='<input type="button" value="Update" data_id="'+id+'" id="btn_edit" class="update btn btn-primary">';
		user +='<input type="button" value="Cancel" class="cancel btn btn-danger">';
		
		$('#editdv').html(user);
	});
	$('#tabs').find('a').eq(1).trigger('click');	
 });
 
$('#editdv').on('click','#role_id',function(){
	var arr	= $('#assgn_role').val().split(',');
	var x = $.inArray($('#rn_edit').val(),arr);
	if(x=='-1'){
		/*comment code from here*/
		$('#assgn_role').val($('#assgn_role').val()+','+$('#rn_edit').val());
		$('#edit_role_list').append('<div><span>'+$('#rn_edit option:selected').text()+'<button class="remove_role_edit fa fa-minus" href="javascript:void(0);" style="color:red; boder:2px solid green;" data_remove="'+$('#rn_edit').val()+'"></button></span></div>');
	}
});
$('#editdv').on('click','.remove_role_edit',function(){	
	$(this).closest('div').remove();
	var arr	= $('#assgn_role').val().split(',');
	var x = $.inArray($(this).attr('data_remove'),arr);
	if(x!='-1'){
		var p =arr.splice(x,1);
		$('#assgn_role').val(arr.join(','));
	}
}); 
 
$('#editdv').on('click','.update',function(){
	var id1=$(this).attr('data_id');
	var unm1=$('#unm').val();
	var exn1=$('#exn').val();
	var dmn1=$('#dmn').val();
    var dnm1=$('#dnm').val();
	var sts1=$('#sts').val();
    if(unm1=='' || exn1=='' || dmn1=='' || dnm1=='' || sts1=='')
	  {
		 alert("All fields are required!!!");
		 return false;		
	  }
    else{
	  //alert("all values present");
		$.post("useredit.php",{
			'user_id':id1,
			'user_name':unm1,
			'ext_no':exn1,
			'domain':dmn1,
			'dept_name':dnm1,
			'act':sts1,
			'role_id':$("#assgn_role").val(),
			'action':'update'}
			,function(res){
				//alert(res);
			if(res!=0){
				alert("Values Updated");
				$.post("user.php",{},function(res){
					$('#section1').html(res);
				});
			}else{
				var x=0;
				alert("Error Occured");
			}
			
		});
		
	}
});
$('#editdv').on('click','.cancel',function(){
	var con=confirm("Are you sure to cancel?");
		  if(con){
			  $('#unm').val('');
			  $('#exn').val('');
			  $('#dnm').val('');
			  $('#dmn').val('');
			  $('#sts').val('Active');  
		  } 
		  
});

$('#role_id').click(function(){
	var arr	= $('#ass_role').val().split(',');
	var x = $.inArray($('#rn').val(),arr);
	if(x=='-1'){
		$('#ass_role').val($('#ass_role').val()+','+$('#rn').val());
		$('#dv_ass_role').append('<div><span>'+$('#rn option:selected').text()+'<button class="remove_role fa fa-minus" href="javascript:void(0);" style="color:red; boder:2px solid green;" data_remove="'+$('#rn').val()+'"></button></span></div>');
	}
});

$('#dv_ass_role').on('click','.remove_role',function(){	
	$(this).closest('div').remove();
	var arr	= $('#ass_role').val().split(',');
	var x = $.inArray($(this).attr('data_remove'),arr);
	if(x!='-1'){
		var p =arr.splice(x,1);
		$('#ass_role').val(arr.join(','));
	}
});
 </script>
