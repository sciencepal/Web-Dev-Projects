<?php
session_start();
include_once('dbconnect.php');
$query="SELECT plant_id,plant_name,act,org_id,loc_id,unit_id FROM jts__t_plant";
$data=mysql_query($query);
$cont="<h3 align='center'>PLANT</h3><br/>";
$cont.= "<table border=1 id='tbl_plant' class='table table-striped table-bordered table-hover'>";
$cont.= "<tr>";
$cont.= "<th>ORGANISATION NAME</th>";
$cont.= "<th>UNIT NAME</th>";
$cont.= "<th>LOCATION NAME</th>";
$cont.= "<th>PLANT NAME</th>";
$cont.= "<th>STATE</th>";
$cont.= "<th>ACTION</th>";
$cont.= "</tr>";
$cont.= "<tr>";
$query1="SELECT org_name FROM jts__t_org";
$data1=mysql_query($query1);
$cont.="<td align='center'>";
$cont.="<select name='org_name' id='oi'>";
while($row1=mysql_fetch_array($data1))
{
	$cont.="<option value='".$row1['org_name']."'>".$row1['org_name']."</option>";
}
$cont.="</select></td>";
$query1="SELECT unit_name FROM jts__t_unit";
$data1=mysql_query($query1);
$cont.="<td align='center'>";
$cont.="<select name='unit_name' id='ui'>";
while($row1=mysql_fetch_array($data1))
{
	$cont.="<option value='".$row1['unit_name']."'>".$row1['unit_name']."</option>";
}
$cont.="</select></td>";
$query1="SELECT loc_name FROM jts__t_loc";
$data1=mysql_query($query1);
$cont.="<td align='center'>";
$cont.="<select name='loc_name' id='li'>";
while($row1=mysql_fetch_array($data1))
{
	$cont.="<option value='".$row1['loc_name']."'>".$row1['loc_name']."</option>";
}
$cont.="</select></td>";
$cont.= "<td align='center'><input type='text' name='plant_name' id='pn' placeholder='PLANT NAME'></td>";
$cont.= "<td align='center'><select name='act' id='act1'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select></td>";
$cont.= "<td align='center'><input type='button' id='add' value='Add' class='btn btn-primary'></td>";
$cont.= "</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	$r=$row["org_id"];
	$query1="SELECT org_name FROM jts__t_org WHERE org_id='$r'";
	$data1=mysql_query($query1);
    $row1=mysql_fetch_array($data1);
	$cont.= "<td align='center'>".$row1["org_name"]."</td>";
	$r=$row["unit_id"];
	$query1="SELECT unit_name FROM jts__t_unit WHERE unit_id='$r'";
	$data1=mysql_query($query1);
    $row1=mysql_fetch_array($data1);
	$cont.= "<td align='center'>".$row1["unit_name"]."</td>";
	$r=$row["loc_id"];
	$query1="SELECT loc_name FROM jts__t_loc WHERE loc_id='$r'";
	$data1=mysql_query($query1);
    $row1=mysql_fetch_array($data1);
	$cont.= "<td align='center'>".$row1["loc_name"]."</td>";
	$cont.= "<td align='center'>".$row["plant_name"]."</td>";
	$cont.= "<td align='center'>".$row["act"]."</td>";
	$cont.= "<td align='center'><input type='button' data='".$row[plant_id]."' data_org='".$row[org_id]."' data_unit='".$row[unit_id]."' data_loc='".$row[loc_id]."' class='demo_edit btn btn-primary' value='Edit'></td>";
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
	if($("#oi").val()=='' || $("#ui").val()=='' || $("#li").val()=='' || $("#pn").val()=='' || $("#act1").val()==''){
		alert("All fields are required!!!");
		return false;		
	}else{
		$.post("plantadd.php",{
			'org_name':$("#oi").val(),
			'unit_name':$("#ui").val(),
			'loc_name':$("#li").val(),
			'plant_name':$("#pn").val(),
			'act':$("#act1").val()}
			,function(res){
				if(res!='0'){
					var  new_tr = "<tr>";
						 new_tr +="<td align='center'>"+$('#oi').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#ui').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#li').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#pn').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#act1').val()+"</td>";
						 new_tr +="<td align='center'><input type='button' value='edit' class='demo_edit btn btn-primary'></td>";
						 new_tr +="</tr>";
					$('#tbl_plant').append(new_tr);
					$("#oi").val('');
					$("#ui").val('');
					$("#li").val('');
					$("#pn").val('');
					$("#act1").val('Active');
				}else{
					alert("An error occured.");
				}
			});		
	}

});
$("#tbl_plant").on("click",".demo_edit",function(){
	 var edit_tr=$(this).closest('tr');
	 var org_name=edit_tr.find('td').eq(0).html();
	 var unit_name=edit_tr.find('td').eq(1).html();
	 var loc_name=edit_tr.find('td').eq(2).html();
	 var plant_name=edit_tr.find('td').eq(3).html();
	 var act=edit_tr.find('td').eq(4).html();
	 var plant_id=$(this).attr('data');
	 var org_id=$(this).attr('data_org');
	 var unit_id=$(this).attr('data_unit');
	 var loc_id=$(this).attr('data_loc');
	 
     edit_tr.find('td').eq(0).html("<?php
	    $con="<select name='on' class='sel_act'>";
	    $query="SELECT org_name FROM jts__t_org";
		$data=mysql_query($query);
		while($row=mysql_fetch_array($data))
		{
			$con.="<option value='".$row['org_name']."'>".$row['org_name']."</option>";
		}
		$con.="</select>";
		print $con;
	 ?>");
	 edit_tr.find('td').eq(0).find('.sel_act').val(org_name);
     edit_tr.find('td').eq(1).html("<?php
	    $con="<select name='un' class='sel_act'>";
	    $query="SELECT unit_name FROM jts__t_unit";
		$data=mysql_query($query);
		while($row=mysql_fetch_array($data))
		{
			$con.="<option value='".$row['unit_name']."'>".$row['unit_name']."</option>";
		}
		$con.="</select>";
		print $con;
	 ?>");
	 edit_tr.find('td').eq(1).find('.sel_act').val(unit_name);
     edit_tr.find('td').eq(2).html("<?php
	    $con="<select name='ln' class='sel_act'>";
	    $query="SELECT loc_name FROM jts__t_loc";
		$data=mysql_query($query);
		while($row=mysql_fetch_array($data))
		{
			$con.="<option value='".$row['loc_name']."'>".$row['loc_name']."</option>";
		}
		$con.="</select>";
		print $con;
	 ?>");
     edit_tr.find('td').eq(2).find('.sel_act').val(loc_name);	 
	 edit_tr.find('td').eq(3).html('<input type="text" class="text_box" value="'+plant_name+'" />');
	 edit_tr.find('td').eq(4).html("<select name='act' class='sel_act'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select>");
	 edit_tr.find('td').eq(4).find('.sel_act').val(act);
	 edit_tr.find('td').eq(5).html('<input type="button" value="Update" data_id="'+plant_id+'" data_org1="'+org_id+'" data_unit1="'+unit_id+'" data_loc1="'+loc_id+'" class="update btn btn-primary"><input type="button" value="Cancel" data_id="'+plant_id+'" pn="'+plant_name+'" on="'+org_name+'" un="'+unit_name+'" ln="'+loc_name+'" pa="'+act+'" class="cancel btn btn-danger">');
});

  $("#tbl_plant").on("click",".update",function(){
	  var pi1=$(this).attr('data_id');
	  var oi1=$(this).attr('data_org1');
	  var ui1=$(this).attr('data_unit1');
	  var li1=$(this).attr('data_loc1');
	  var edit_tr1=$(this).closest('tr').find('td');
	  var on1=edit_tr1.eq(0).find('.sel_act').val();
	  var un1=edit_tr1.eq(1).find('.sel_act').val();
	  var ln1=edit_tr1.eq(2).find('.sel_act').val();
	  var pn1=edit_tr1.eq(3).find('.text_box').val();
	  var pa1=edit_tr1.eq(4).find('.sel_act').val();
	  if(on1=='' || un1=='' || ln1=='' || pn1=='' || pa1=='')
	  {
		alert("All fields are required!!!");
		return false;		
	  }
	  else{
		  //alert("all values present");
	        $.post("plantedit.php",{
		    'plant_id':pi1,
			'org_id':oi1,
			'unit_id':ui1,
			'loc_id':li1,
			'org_name':on1,
			'loc_name':ln1,
			'unit_name':un1,
			'plant_name':pn1,
			'act':pa1}
			,function(res){
			if(res!=0)
			{
				edit_tr1.eq(0).html(on1);
				edit_tr1.eq(1).html(un1);
				edit_tr1.eq(2).html(ln1);
				edit_tr1.eq(3).html(pn1);
				edit_tr1.eq(4).html(pa1);
				edit_tr1.eq(5).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
			}
			else{
				alert("Error Occured");
			}
  });
	  }
	  });
	  
	   $("#tbl_plant").on("click",".cancel",function(){
		   var con=confirm("Are you sure to cancel?");
		  if(con){
			var pi1=$(this).attr('data_id');
			  var edit_tr1=$(this).closest('tr').find('td'); 
			  edit_tr1.eq(0).html($(this).attr('on'));
			  edit_tr1.eq(1).html($(this).attr('un'));
			  edit_tr1.eq(2).html($(this).attr('ln'));
			  edit_tr1.eq(3).html($(this).attr('pn'));
			  edit_tr1.eq(4).html($(this).attr('pa'));
			  edit_tr1.eq(5).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");  
		  } 
		  
		  
	   });
 </script>
 </body>
 </html>