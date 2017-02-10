<?php
session_start();
include_once('dbconnect.php');
$query="SELECT * FROM jts__t_app_plant";
$data=mysql_query($query);
$cont="<h3 align='center'>APPLICATION PLANT ASSIGNMENT</h3><br/>";
$cont.= "<table border=1 id='tbl_appplant' class='table table-striped table-bordered table-hover'>";
$cont.= "<tr>";
$cont.= "<th>APPLICATION NAME</th>";
$cont.= "<th>PLANT NAME</th>";
$cont.= "<th>STATE</th>";
$cont.= "<th>ACTION</th>";
$cont.= "</tr>";
$cont.= "<tr>";
$query1="SELECT app_name FROM jts__t_app";
$data1=mysql_query($query1);
$cont.="<td align='center'>";
$cont.="<select name='app_name' id='an'>";
while($row1=mysql_fetch_array($data1))
{
	$cont.="<option value='".$row1['app_name']."'>".$row1['app_name']."</option>";
}
$cont.="</select></td>";

$query1="SELECT plant_name FROM jts__t_plant";
$data1=mysql_query($query1);
$cont.="<td align='center'>";
$cont.="<select name='plant_name' id='pn'>";
while($row1=mysql_fetch_array($data1))
{
	$cont.="<option value='".$row1['plant_name']."'>".$row1['plant_name']."</option>";
}
$cont.="</select></td>";
//$cont.= "<td align='center'><input type='text' name='app_name' id='an' placeholder='APPLICATION NAME'></td>";
//$cont.= "<td align='center'><textarea type='text' name='plant_name' id='pn' placeholder='PLANT NAME'></textarea></td>";
$cont.= "<td align='center'><select name='act' id='act1'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select></td>";
$cont.= "<td align='center'><input type='button' id='add' value='Add' class='btn btn-primary'></td>";
$cont.= "</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	$r=$row["app_id"];
	$query="SELECT app_name FROM jts__t_app WHERE app_id='$r'";
	$data1=mysql_query($query);
	$row1=mysql_fetch_array($data1);
	$cont.= "<td align='center'>".$row1["app_name"]."</td>";
	$r=$row["plant_id"];
	$query="SELECT plant_name FROM jts__t_plant WHERE plant_id='$r'";
	$data1=mysql_query($query);
	$row1=mysql_fetch_array($data1);
	$cont.= "<td align='center'>".$row1["plant_name"]."</td>";
	$cont.= "<td align='center'>".$row["act"]."</td>";
	$cont.= "<td align='center'><input type='button' data='".$row[app_id]."' data_pi='".$row[plant_id]."' class='demo_edit btn btn-primary' value='Edit'></td>";
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
	if($("#an").val()=='' || $("#pn").val()=='' || $("#act1").val()==''){
		alert("All fields are required!!!");
		return false;		
	}else{
		//alert($("#pn").val());
		$.post("appplantadd.php",{
			'app_name':$("#an").val(),
			'plant_name':$("#pn").val(),
			'act':$("#act1").val()}
			,function(res){
				//alert(res);
				if(res!='0'){
					var  new_tr = "<tr>";
						 new_tr +="<td align='center'>"+$('#an').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#pn').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#act1').val()+"</td>";
						 new_tr +="<td align='center'><input type='button' value='Edit' class='demo_edit btn btn-primary'></td>";
						 new_tr +="</tr>";
					$('#tbl_appplant').append(new_tr);
					$("#an").val('');
					$("#pn").val('');
					$("#act1").val('Active');
					//alert("An error occured.");
				}else{
					alert("An error occured.");
				}
			});		
	}

});
 $("#tbl_appplant").on("click",".demo_edit",function(){
	 var edit_tr=$(this).closest('tr');
	 var app_name=edit_tr.find('td').eq(0).html();
	 var plant_name=edit_tr.find('td').eq(1).html();
	 var act=edit_tr.find('td').eq(2).html();
	 var app_id=$(this).attr('data');
	 var plant_id=$(this).attr('data_pi');
	 	 
	 edit_tr.find('td').eq(0).html("<?php
		$con="<select name='an' class='sel_act'>";
		$query="SELECT app_name FROM jts__t_app";
		$data=mysql_query($query);
		while($row=mysql_fetch_array($data))
		{
			$con.="<option value='".$row['app_name']."'>".$row['app_name']."</option>";
		}
		$con.="</select>";
		print $con;
	 ?>");
	 edit_tr.find('td').eq(0).find('.sel_act').val(app_name);
     edit_tr.find('td').eq(1).html("<?php
	    $con="<select name='pn' class='sel_act'>";
	    $query="SELECT plant_name FROM jts__t_plant";
		$data=mysql_query($query);
		while($row=mysql_fetch_array($data))
		{
			$con.="<option value='".$row['plant_name']."'>".$row['plant_name']."</option>";
		}
		$con.="</select>";
		print $con;
	 ?>");
	 edit_tr.find('td').eq(1).find('.sel_act').val(plant_name);
	 edit_tr.find('td').eq(2).html("<select name='act' class='sel_act'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select>");
	 edit_tr.find('td').eq(2).find('.sel_act').val(act);
	 edit_tr.find('td').eq(3).html('<input type="button" value="Update" data_id="'+app_id+'" data_id1="'+plant_id+'" class="update btn btn-primary"><input type="button" value="Cancel" data_id="'+app_id+'" dn="'+app_name+'" dd="'+plant_name+'"  da="'+act+'" class="cancel btn btn-danger">');
	 
 });
 $("#tbl_appplant").on("click",".update",function(){
	  var ai1=$(this).attr('data_id');
	  var pi1=$(this).attr('data_id1');
	  var edit_tr1=$(this).closest('tr').find('td');
	  var an1=edit_tr1.eq(0).find('.sel_act').val();
	  var pn1=edit_tr1.eq(1).find('.sel_act').val();
	  var as1=edit_tr1.eq(2).find('.sel_act').val();
	  if(an1=='' || pn1=='' || as1=='')
	  {
		alert("All fields are required!!!");
		return false;		
	  }
	  else{
		  //alert("all values present");
	        $.post("appplantedit.php",{
		    'app_id':ai1,
			'plant_id':pi1,
			'app_name':an1,
			'plant_name':pn1,
			'act':as1}
			,function(res){
			//alert(res);
			if(res!=0)
			{
				edit_tr1.eq(0).html(an1);
				edit_tr1.eq(1).html(pn1);
				edit_tr1.eq(2).html(as1);
				edit_tr1.eq(3).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
			}
			else{
				alert("Error Occured");
			}
  });
	  }
	  });
	   $("#tbl_appplant").on("click",".cancel",function(){
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