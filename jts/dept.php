<?php
session_start();
include_once('dbconnect.php');
$query="SELECT dept_id,dept_name,plant_id,act FROM jts__t_dept";
$data=mysql_query($query);
$cont="<h3 align='center'>DEPARTMENT</h3><br/>";
$cont.= "<table border=1 id='tbl_dept' class='table table-striped table-bordered table-hover'>";
$cont.= "<tr>";
$cont.= "<th>PLANT NAME</th>";
$cont.= "<th>DEPARTMENT NAME</th>";
$cont.= "<th>STATE</th>";
$cont.= "<th>ACTION</th>";
$cont.= "</tr>";
$cont.= "<tr>";
$query1="SELECT plant_name FROM jts__t_plant";
$data1=mysql_query($query1);
$cont.="<td align='center'>";
$cont.="<select name='plant_name' id='pi'>";
while($row1=mysql_fetch_array($data1))
{
	$cont.="<option value='".$row1['plant_name']."'>".$row1['plant_name']."</option>";
}
$cont.="</select></td>";
$cont.= "<td align='center'><input type='text' name='dept_name' id='dn' placeholder='DEPARTMENT NAME'></td>";
$cont.= "<td align='center'><select name='act' id='act1'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select></td>";
$cont.= "<td align='center'><input type='button' id='add' value='Add' class='btn btn-primary'></td>";
$cont.= "</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	$r=$row["plant_id"];
	$query="SELECT plant_name FROM jts__t_plant WHERE plant_id='$r'";
	$data1=mysql_query($query);
	$row1=mysql_fetch_array($data1);
	$cont.= "<td align='center'>".$row1["plant_name"]."</td>";
	$cont.= "<td align='center'>".$row["dept_name"]."</td>";
	$cont.= "<td align='center'>".$row["act"]."</td>";
	$cont.= "<td align='center'><input type='button' data='".$row[dept_id]."' data_plant='".$row[plant_id]."' class='demo_edit btn btn-primary' value='Edit'></td>";
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
	if($("#pi").val()=='' || $("#dn").val()=='' || $("#act1").val()==''){
		alert("All fields are required!!!");
		return false;		
	}else{
		$.post("deptadd.php",{
			'plant_name':$("#pi").val(),
			'dept_name':$("#dn").val(),
			'act':$("#act1").val()}
			,function(res){
				if(res!='0'){
					var  new_tr = "<tr>";
						 new_tr +="<td align='center'>"+$('#pi').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#dn').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#act1').val()+"</td>";
						 new_tr +="<td align='center'><input type='button' value='edit' class='demo_edit btn btn-primary'></td>";
						 new_tr +="<tr>";
					$('#tbl_dept').append(new_tr);
					$("#pi").val('');
					$("#dn").val('');
					$("#act1").val('Active');
					//alert("An error occured.");
				}else{
					alert("An error occured.");
				}
			});		
	}

});
 $("#tbl_dept").on("click",".demo_edit",function(){
	 var edit_tr=$(this).closest('tr');
	 var plant_name=edit_tr.find('td').eq(0).html();
	 var dept_name=edit_tr.find('td').eq(1).html();
	 var act=edit_tr.find('td').eq(2).html();
	 var dept_id=$(this).attr('data');
	 var plant_id=$(this).attr('data_plant');
	 	 
	 edit_tr.find('td').eq(0).html("<?php
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
	 edit_tr.find('td').eq(0).find('.sel_act').val(plant_name);
	 edit_tr.find('td').eq(1).html('<input type="text" class = "text_box" value="'+dept_name+'" />');
	 edit_tr.find('td').eq(2).html("<select name='act' class='sel_act'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select>");
	 edit_tr.find('td').eq(2).find('.sel_act').val(act);
	 edit_tr.find('td').eq(3).html('<input type="button" value="Update" data_id="'+dept_id+'" data_plant_id="'+plant_id+'" class="update btn btn-primary"><input type="button" value="Cancel" data_id="'+dept_id+'" pn="'+plant_name+'" da="'+act+'" dn="'+dept_name+'" class="cancel btn btn-danger">');
	 
 });
  $("#tbl_dept").on("click",".update",function(){
	  var di1=$(this).attr('data_id');
	  var pi1=$(this).attr('data_plant_id');
	  var edit_tr1=$(this).closest('tr').find('td');
	  var pn1=edit_tr1.eq(0).find('.sel_act').val();
	  var dn1=edit_tr1.eq(1).find('.text_box').val();
	  var da1=edit_tr1.eq(2).find('.sel_act').val();
	  if(pn1=='' || dn1=='' || da1=='')
	  {
		alert("All fields are required!!!");
		return false;		
	  }
	  else{
		  //alert("all values present");
	        $.post("deptedit.php",{
		    'dept_id':di1,
			'plant_id':pi1,
			'dept_name':dn1,
			'plant_name':pn1,
			'act':da1}
			,function(res){
				//alert(res);
			if(res!=0)
			{
				edit_tr1.eq(0).html(pn1);
				edit_tr1.eq(1).html(dn1);
				edit_tr1.eq(2).html(da1);
				edit_tr1.eq(3).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
			}
			else{
				alert("Error Occured");
			}
  });
	  }
	  });
	   $("#tbl_dept").on("click",".cancel",function(){
		   var con=confirm("Are you sure to cancel?");
		  if(con){
		  var di1=$(this).attr('data_id');
	      var edit_tr1=$(this).closest('tr').find('td'); 
		  edit_tr1.eq(0).html($(this).attr('pn'));
		  edit_tr1.eq(1).html($(this).attr('dn'));
		  edit_tr1.eq(2).html($(this).attr('da'));
		  edit_tr1.eq(3).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
		  }
		  }); 

 </script>
 </body>
 </html>