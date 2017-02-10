<?php
session_start();
include_once('dbconnect.php');
$query="SELECT org_id,org_name,act FROM jts__t_org";
$data=mysql_query($query);
$cont="<h3 align='center'>ORGANISATION</h3><br/>";
$cont.= "<table border=1 id='tbl_org' class='table table-striped table-bordered table-hover'>";
$cont.= "<tr>";
$cont.= "<th>ORGANISATION NAME</th>";
$cont.= "<th>STATE</th>";
$cont.= "<th>ACTION</th>";
$cont.= "</tr>";
$cont.= "<tr>";
$cont.= "<td align='center'><input type='text' name='org_name' id='on' placeholder='ORGANISATION NAME'></td>";
$cont.= "<td align='center'><select name='act' id='act1'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select></td>";
$cont.= "<td align='center'><input type='button' id='add' value='Add' class='btn btn-primary'></td>";
$cont.= "</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	$cont.= "<td align='center'>".$row["org_name"]."</td>";
	$cont.= "<td align='center'>".$row["act"]."</td>";
	$cont.= "<td align='center'><input type='button' data='".$row[org_id]."' class='demo_edit btn btn-primary' value='Edit'></td>";
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
	if($("#on").val()=='' || $("#act1").val()==''){
		alert("All fields are required!!!");
		return false;		
	}else{
		$.post("orgadd.php",{
			'org_name':$("#on").val(),
			'act':$("#act1").val()}
			,function(res){
				if(res!='0'){
					var  new_tr = "<tr>";
						 new_tr +="<td align='center'>"+$('#on').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#act1').val()+"</td>";
						 new_tr +="<td align='center'><input type='button' value='Edit' class='demo_edit btn btn-primary'></td>";
						 new_tr +="<tr>";
					$('#tbl_org').append(new_tr);
					$("#on").val('');
					$("#act1").val('Active');
					//alert("An error occured.");
				}else{
					alert("An error occured.");
				}
			});		
	}

});
 $("#tbl_org").on("click",".demo_edit",function(){
	 var edit_tr=$(this).closest('tr');
	 var org_name=edit_tr.find('td').eq(0).html();
	 var act=edit_tr.find('td').eq(1).html();
	 var org_id=$(this).attr('data');
	 	 
	 edit_tr.find('td').eq(0).html('<input type="text" class="text_box" value="'+org_name+'" />');
	 edit_tr.find('td').eq(1).html("<select name='act' class='sel_act'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select>");
	 edit_tr.find('td').eq(1).find('.sel_act').val(act);
	 edit_tr.find('td').eq(2).html('<input type="button" value="Update" data_id="'+org_id+'" class="update btn btn-primary"><input type="button" value="Cancel" data_id="'+org_id+'" dn="'+org_name+'" da="'+act+'" class="cancel btn btn-danger">');
	 
 });
 $("#tbl_org").on("click",".update",function(){
	  var oi1=$(this).attr('data_id');
	  var edit_tr1=$(this).closest('tr').find('td');
	  var on1=edit_tr1.eq(0).find('.text_box').val();
	  var os1=edit_tr1.eq(1).find('.sel_act').val();
	  if(on1=='' || os1=='')
	  {
		alert("All fields are required!!!");
		return false;		
	  }
	  else{
		  //alert("all values present");
	        $.post("orgedit.php",{
		    'org_id':oi1,
			'org_name':on1,
			'act':os1}
			,function(res){
				//alert(res);
			if(res!=0)
			{
				edit_tr1.eq(0).html(on1);
				edit_tr1.eq(1).html(os1);
				edit_tr1.eq(2).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
			}
			else{
				alert("Error Occured");
			}
  });
	  }
	  });
	   $("#tbl_org").on("click",".cancel",function(){
		   var con=confirm("Are you sure to cancel?");
		  if(con){
		  var di1=$(this).attr('data_id');
	      var edit_tr1=$(this).closest('tr').find('td'); 
		  edit_tr1.eq(0).html($(this).attr('dn'));
		  edit_tr1.eq(1).html($(this).attr('da'));
		  edit_tr1.eq(2).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
		  }
		  });
 </script>
 </body>
 </html>