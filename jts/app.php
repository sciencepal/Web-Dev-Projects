<?php
session_start();
include_once('dbconnect.php');
$query="SELECT app_id,app_name,app_desc,act FROM jts__t_app";
$data=mysql_query($query);
$cont="<h3 align='center'>APPLICATION</h3><br/>";
$cont.= "<table border=1 id='tbl_app' class='table table-striped table-bordered table-hover'>";
$cont.= "<tr>";
$cont.= "<th>APPLICATION NAME</th>";
$cont.= "<th>APPLICATION DESCRIPTION</th>";
$cont.= "<th>STATE</th>";
$cont.= "<th>ACTION</th>";
$cont.= "</tr>";
$cont.= "<tr>";
$cont.= "<td align='center'><input type='text' name='app_name' id='an' placeholder='APPLICATION NAME'></td>";
$cont.= "<td align='center'><textarea type='text' name='app_desc' id='ad' placeholder='APPLICATION DESCRIPTION'></textarea></td>";
$cont.= "<td align='center'><select name='act' id='act1'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select></td>";
$cont.= "<td align='center'><input type='button' id='add' value='Add' class='btn btn-primary'></td>";
$cont.= "</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	$cont.= "<td align='center'>".$row["app_name"]."</td>";
	$cont.= "<td align='center'>".$row["app_desc"]."</td>";
	$cont.= "<td align='center'>".$row["act"]."</td>";
	$cont.= "<td align='center'><input type='button' data='".$row[app_id]."' class='demo_edit btn btn-primary' value='Edit'></td>";
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
	if($("#an").val()=='' || $("#ad").val()=='' || $("#act1").val()==''){
		alert("All fields are required!!!");
		return false;		
	}else{
		$.post("appadd.php",{
			'app_name':$("#an").val(),
			'app_desc':$("#ad").val(),
			'act':$("#act1").val()}
			,function(res){
				if(res!='0'){
					var  new_tr = "<tr>";
						 new_tr +="<td align='center'>"+$('#an').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#ad').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#act1').val()+"</td>";
						 new_tr +="<td align='center'><input type='button' value='Edit' class='demo_edit btn btn-primary'></td>";
						 new_tr +="<tr>";
					$('#tbl_app').append(new_tr);
					$("#an").val('');
					$("#ad").val('');
					$("#act1").val('Active');
					//alert("An error occured.");
				}else{
					alert("An error occured.");
				}
			});		
	}

});
 $("#tbl_app").on("click",".demo_edit",function(){
	 var edit_tr=$(this).closest('tr');
	 var app_name=edit_tr.find('td').eq(0).html();
	 var app_desc=edit_tr.find('td').eq(1).html();
	 var act=edit_tr.find('td').eq(2).html();
	 var app_id=$(this).attr('data');
	 	 
	 edit_tr.find('td').eq(0).html('<input type="text" class="text_box" value="'+app_name+'" />');
	 edit_tr.find('td').eq(1).html('<textarea class="text_box">'+app_desc+'</textarea>');
	 edit_tr.find('td').eq(2).html("<select name='act' class='sel_act'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select>");
	 edit_tr.find('td').eq(2).find('.sel_act').val(act);
	 edit_tr.find('td').eq(3).html('<input type="button" value="Update" data_id="'+app_id+'" class="update btn btn-primary"><input type="button" value="Cancel" data_id="'+app_id+'" dn="'+app_name+'" dd="'+app_desc+'"  da="'+act+'" class="cancel btn btn-danger">');
	 
 });
 $("#tbl_app").on("click",".update",function(){
	  var ai1=$(this).attr('data_id');
	  var edit_tr1=$(this).closest('tr').find('td');
	  var an1=edit_tr1.eq(0).find('.text_box').val();
	  var ad1=edit_tr1.eq(1).find('.text_box').val();
	  var as1=edit_tr1.eq(2).find('.sel_act').val();
	  if(an1=='' || ad1=='' || as1=='')
	  {
		alert("All fields are required!!!");
		return false;		
	  }
	  else{
		  //alert("all values present");
	        $.post("appedit.php",{
		    'app_id':ai1,
			'app_name':an1,
			'app_desc':ad1,
			'act':as1}
			,function(res){
				//alert(res);
			if(res!=0)
			{
				edit_tr1.eq(0).html(an1);
				edit_tr1.eq(1).html(ad1);
				edit_tr1.eq(2).html(as1);
				edit_tr1.eq(3).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
			}
			else{
				alert("Error Occured");
			}
  });
	  }
	  });
	   $("#tbl_app").on("click",".cancel",function(){
		   var con=confirm("Are you sure to cancel?");
		  if(con){
		  var ai1=$(this).attr('data_id');
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