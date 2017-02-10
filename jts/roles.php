<?php
session_start();
include_once('dbconnect.php');
$query="SELECT role_id,role_name,role_desc,act FROM jts__t_roles";
$data=mysql_query($query);
$cont="<h3 align='center'>ROLES</h3><br/>";
$cont.= "<table border=1 id='tbl_role' class='table table-striped table-bordered table-hover'>";
$cont.= "<tr>";
$cont.= "<th>ROLE NAME</th>";
$cont.= "<th>ROLE DESCRIPTION</th>";
$cont.= "<th>STATE</th>";
$cont.= "<th>ACTION</th>";
$cont.= "</tr>";
$cont.= "<tr>";
$cont.= "<td align='center'><input type='text' name='role_name' id='rn' placeholder='ROLE NAME'></td>";
$cont.= "<td align='center'><textarea type='text' name='role_desc' id='rd' placeholder='ROLE DESCRIPTION'></textarea></td>";
$cont.= "<td align='center'><select name='act' id='act1'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select></td>";
$cont.= "<td align='center'><input type='button' id='add' value='Add' class='btn btn-primary'></td>";
$cont.= "</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	$cont.= "<td align='center'>".$row["role_name"]."</td>";
	$cont.= "<td align='center'>".$row["role_desc"]."</td>";
	$cont.= "<td align='center'>".$row["act"]."</td>";
	$cont.= "<td align='center'><input type='button' data='".$row[role_id]."' class='demo_edit btn btn-primary' value='Edit'></td>";
    $cont.= "</tr>";	
}
$cont.= "</table>";
print $cont;
?>
<html>
<body>
<script type="text/javascript" src="js/jquery-1.12.3.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
$('#add').click(function(){
	if($("#rn").val()=='' || $("#rd").val()=='' || $("#act1").val()==''){
		alert("All fields are required!!!");
		return false;		
	}else{
		$.post("rolesadd.php",{
			'role_name':$("#rn").val(),
			'role_desc':$("#rd").val(),
			'act':$("#act1").val()}
			,function(res){
				if(res!='0'){
					var  new_tr = "<tr>";
						 new_tr +="<td align='center'>"+$('#rn').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#rd').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#act1').val()+"</td>";
						 new_tr +="<td align='center'><input type='button' value='Edit' class='demo_edit btn btn-primary'></td>";
						 new_tr +="<tr>";
					$('#tbl_role').append(new_tr);
					$("#rn").val('');
					$("#rd").val('');
					$("#act1").val('Active');
					//alert("An error occured.");
				}else{
					alert("An error occured.");
				}
			});		
	}

});
 $("#tbl_role").on("click",".demo_edit",function(){
	 var edit_tr=$(this).closest('tr');
	 var role_name=edit_tr.find('td').eq(0).html();
	 var role_desc=edit_tr.find('td').eq(1).html();
	 var act=edit_tr.find('td').eq(2).html();
	 var role_id=$(this).attr('data');
	 	 
	 edit_tr.find('td').eq(0).html('<input type="text" class="text_box" value="'+role_name+'" />');
	 edit_tr.find('td').eq(1).html('<textarea class="text_box">'+role_desc+'</textarea>');
	 //edit_tr.find('td').eq(1).html('<textarea type="text" class="text_box" value="'+role_desc+'" /></textarea>');
	 edit_tr.find('td').eq(2).html("<select name='act' class='sel_act'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select>");
	 edit_tr.find('td').eq(2).find('.sel_act').val(act);
	 edit_tr.find('td').eq(3).html('<input type="button" value="Update" data_id="'+role_id+'" class="update btn btn-primary"><input type="button" value="Cancel" data_id="'+role_id+'" dn="'+role_name+'" dd="'+role_desc+'"  da="'+act+'" class="cancel btn btn-danger">');
	 
 });
 $("#tbl_role").on("click",".update",function(){
	  var ri1=$(this).attr('data_id');
	  var edit_tr1=$(this).closest('tr').find('td');
	  var rn1=edit_tr1.eq(0).find('.text_box').val();
	  var rd1=edit_tr1.eq(1).find('.text_box').val();
	  var rs1=edit_tr1.eq(2).find('.sel_act').val();
	  if(rn1=='' || rd1=='' || rs1=='')
	  {
		alert("All fields are required!!!");
		return false;		
	  }
	  else{
		  //alert("all values present");
	        $.post("rolesedit.php",{
		    'role_id':ri1,
			'role_name':rn1,
			'role_desc':rd1,
			'act':rs1}
			,function(res){
				//alert(res);
			if(res!=0)
			{
				edit_tr1.eq(0).html(rn1);
				edit_tr1.eq(1).html(rd1);
				edit_tr1.eq(2).html(rs1);
				edit_tr1.eq(3).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
			}
			else{
				alert("Error Occured");
			}
  });
	  }
	  });
	   $("#tbl_role").on("click",".cancel",function(){
		   var con=confirm("Are you sure to cancel?");
		  if(con){
		  var di1=$(this).attr('data_id');
	      var edit_tr1=$(this).closest('tr').find('td'); 
		  edit_tr1.eq(0).html($(this).attr('dn'));
		  edit_tr1.eq(1).html($(this).attr('dd'));
		  edit_tr1.eq(2).html($(this).attr('da'));
		  edit_tr1.eq(3).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
		  }
		  });
 </script>
 </body>
 </html>