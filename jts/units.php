<?php
session_start();
include_once('dbconnect.php');
$query="SELECT unit_id,unit_name,act FROM jts__t_unit";
$data=mysql_query($query);
$cont="<h3 align='center'>UNITS</h3><br/>";
$cont.= "<table border=1 id='tbl_unit' class='table table-striped table-bordered table-hover'>";
$cont.= "<tr>";
$cont.= "<th>UNIT NAME</th>";
$cont.= "<th>STATE</th>";
$cont.= "<th>ACTION</th>";
$cont.= "</tr>";
$cont.= "<tr>";
$cont.= "<td align='center'><input type='text' name='unit_name' id='un' placeholder='UNIT NAME'></td>";
$cont.= "<td align='center'><select name='act' id='act1'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select></td>";
$cont.= "<td align='center'><input type='button' id='add' value='Add' class='btn btn-primary'></td>";
$cont.= "</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	$cont.= "<td align='center'>".$row["unit_name"]."</td>";
	$cont.= "<td align='center'>".$row["act"]."</td>";
	$cont.= "<td align='center'><input type='button' data='".$row[unit_id]."' class='demo_edit btn btn-primary' value='Edit'></td>";
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
	if($("#un").val()=='' || $("#act1").val()==''){
		alert("All fields are required!!!");
		return false;		
	}else{
		$.post("unitadd.php",{
			'unit_name':$("#un").val(),
			'act':$("#act1").val()}
			,function(res){
				if(res!='0'){
					var  new_tr = "<tr>";
						 new_tr +="<td align='center'>"+$('#un').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#act1').val()+"</td>";
						 new_tr +="<td align='center'><input type='button' value='edit' class='demo_edit btn btn-primary'></td>";
						 new_tr +="<tr>";
					$('#tbl_unit').append(new_tr);
					$("#un").val('');
					$("#act1").val('Active');
					//alert("An error occured.");
				}else{
					alert("An error occured.");
				}
			});		
	}

});

$("#tbl_unit").on("click",".demo_edit",function(){
	 var edit_tr=$(this).closest('tr');
	 var unit_name=edit_tr.find('td').eq(0).html();
	 var act=edit_tr.find('td').eq(1).html();
	 var unit_id=$(this).attr('data');
	 	 
	 edit_tr.find('td').eq(0).html('<input type="text" class="text_box" value="'+unit_name+'" />');
	 edit_tr.find('td').eq(1).html("<select name='act' class='sel_act'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select>");
	 edit_tr.find('td').eq(1).find('.sel_act').val('Inactive');
	 edit_tr.find('td').eq(2).html('<input type="button" value="Update" data_id="'+unit_id+'" class="update btn btn-primary"><input type="button" value="Cancel" data_id="'+unit_id+'" dn="'+unit_name+'" da="'+act+'" class="cancel btn btn-danger">');
	 
 });
 
  $("#tbl_unit").on("click",".update",function(){
	  var ui1=$(this).attr('data_id');
	  var edit_tr1=$(this).closest('tr').find('td');
	  var un1=edit_tr1.eq(0).find('.text_box').val();
	  var us1=edit_tr1.eq(1).find('.sel_act').val();
	  if(un1=='' || us1=='')
	  {
		alert("All fields are required!!!");
		return false;		
	  }
	  else{
		  //alert("all values present");
	        $.post("unitedit.php",{
		    'unit_id':ui1,
			'unit_name':un1,
			'act':us1}
			,function(res){
				//alert(res);
			if(res!=0)
			{
				edit_tr1.eq(0).html(un1);
				edit_tr1.eq(1).html(us1);
				edit_tr1.eq(2).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
			}
			else{
				alert("Error Occured");
			}
  });
	  }
	  });
	   $("#tbl_unit").on("click",".cancel",function(){
		   var con=confirm("Are you sure to cancel?");
		  if(con){
		  var ui1=$(this).attr('data_id');
	      var edit_tr1=$(this).closest('tr').find('td'); 
		  edit_tr1.eq(0).html($(this).attr('dn'));
		  edit_tr1.eq(1).html($(this).attr('da'));
		  edit_tr1.eq(2).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
		  }
		  });
		

 </script>
 </body>
 </html>