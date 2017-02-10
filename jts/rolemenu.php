<?php
session_start();
include_once('dbconnect.php');
$query="SELECT * FROM jts__t_role_menu";
$data=mysql_query($query);
$cont="<h3 align='center'>ROLE MENU ASSIGNMENT</h3><br/>";
$cont.= "<table border=1 id='tbl_rolemenu' class='table table-striped table-bordered table-hover'>";
$cont.= "<tr>";
$cont.= "<th>ROLE NAME</th>";
$cont.= "<th>MENU NAME</th>";
$cont.= "<th>STATE</th>";
$cont.= "<th>ACTION</th>";
$cont.= "</tr>";
$cont.= "<tr>";
$query1="SELECT role_name FROM jts__t_roles";
$data1=mysql_query($query1);
$cont.="<td align='center'>";
$cont.="<select name='role_name' id='rn'>";
while($row1=mysql_fetch_array($data1))
{
	$cont.="<option value='".$row1['role_name']."'>".$row1['role_name']."</option>";
}
$cont.="</select></td>";

$query1="SELECT menu_name FROM jts__t_menu";
$data1=mysql_query($query1);
$cont.="<td align='center'>";
$cont.="<select name='menu_name' id='mn'>";
while($row1=mysql_fetch_array($data1))
{
	$cont.="<option value='".$row1['menu_name']."'>".$row1['menu_name']."</option>";
}
$cont.="</select></td>";
$cont.= "<td align='center'><select name='act' id='act1'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select></td>";
$cont.= "<td align='center'><input type='button' id='add' value='Add' class='btn btn-primary'></td>";
$cont.= "</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	$r=$row["role_id"];
	$query="SELECT role_name FROM jts__t_roles WHERE role_id='$r'";
	$data1=mysql_query($query);
	$row1=mysql_fetch_array($data1);
	$cont.= "<td align='center'>".$row1["role_name"]."</td>";
	$r=$row["menu_id"];
	$query="SELECT menu_name FROM jts__t_menu WHERE menu_id='$r'";
	$data1=mysql_query($query);
	$row1=mysql_fetch_array($data1);
	$cont.= "<td align='center'>".$row1["menu_name"]."</td>";
	$cont.= "<td align='center'>".$row["act"]."</td>";
	$cont.= "<td align='center'><input type='button' data='".$row[role_id]."' data_pi='".$row[menu_id]."' class='demo_edit btn btn-primary' value='Edit'></td>";
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
	if($("#rn").val()=='' || $("#mn").val()=='' || $("#act1").val()==''){
		alert("All fields are required!!!");
		return false;		
	}else{
		//alert($("#pn").val());
		$.post("rolemenuadd.php",{
			'role_name':$("#rn").val(),
			'menu_name':$("#mn").val(),
			'act':$("#act1").val()}
			,function(res){
				//alert(res);
				if(res!='0'){
					var  new_tr = "<tr>";
						 new_tr +="<td align='center'>"+$('#rn').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#mn').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#act1').val()+"</td>";
						 new_tr +="<td align='center'><input type='button' value='Edit' class='demo_edit btn btn-primary'></td>";
						 new_tr +="</tr>";
					$('#tbl_rolemenu').append(new_tr);
					$("#rn").val('');
					$("#mn").val('');
					$("#act1").val('Active');
					//alert("An error occured.");
				}else{
					alert("An error occured.");
				}
			});		
	}

});
 $("#tbl_rolemenu").on("click",".demo_edit",function(){
	 var edit_tr=$(this).closest('tr');
	 var role_name=edit_tr.find('td').eq(0).html();
	 var menu_name=edit_tr.find('td').eq(1).html();
	 var act=edit_tr.find('td').eq(2).html();
	 var role_id=$(this).attr('data');
	 var menu_id=$(this).attr('data_pi');
	 	 
     
	 edit_tr.find('td').eq(0).html("<?php
	    $con="<select name='rn' class='sel_act'>";
	    $query="SELECT role_name FROM jts__t_roles";
		$data=mysql_query($query);
		while($row=mysql_fetch_array($data))
		{
			$con.="<option value='".$row['role_name']."'>".$row['role_name']."</option>";
		}
		$con.="</select>";
		print $con;
	 ?>");
	 edit_tr.find('td').eq(0).find('.sel_act').val(role_name);
     edit_tr.find('td').eq(1).html("<?php
	    $con="<select name='mn' class='sel_act'>";
	    $query="SELECT menu_name FROM jts__t_menu";
		$data=mysql_query($query);
		while($row=mysql_fetch_array($data))
		{
			$con.="<option value='".$row['menu_name']."'>".$row['menu_name']."</option>";
		}
		$con.="</select>";
		print $con;
	 ?>");	
	 edit_tr.find('td').eq(1).find('.sel_act').val(menu_name);
	 edit_tr.find('td').eq(2).html("<select name='act' class='sel_act'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select>");
	 edit_tr.find('td').eq(2).find('.sel_act').val(act);
	 edit_tr.find('td').eq(3).html('<input type="button" value="Update" data_id="'+role_id+'" data_id1="'+menu_id+'" class="update btn btn-primary"><input type="button" value="Cancel" data_id="'+role_id+'" dn="'+role_name+'" dd="'+menu_name+'"  da="'+act+'" class="cancel btn btn-danger">');
	 
 });
 $("#tbl_rolemenu").on("click",".update",function(){
	  var ri1=$(this).attr('data_id');
	  var mi1=$(this).attr('data_id1');
	  var edit_tr1=$(this).closest('tr').find('td');
	  var rn1=edit_tr1.eq(0).find('.sel_act').val();
	  var mn1=edit_tr1.eq(1).find('.sel_act').val();
	  var as1=edit_tr1.eq(2).find('.sel_act').val();
	  if(rn1=='' || mn1=='' || as1=='')
	  {
		alert("All fields are required!!!");
		return false;		
	  }
	  else{
		  //alert("all values present");
	        $.post("rolemenuedit.php",{
		    'role_id':ri1,
			'menu_id':mi1,
			'role_name':rn1,
			'menu_name':mn1,
			'act':as1}
			,function(res){
			//alert(res);
			if(res!=0)
			{
				edit_tr1.eq(0).html(rn1);
				edit_tr1.eq(1).html(mn1);
				edit_tr1.eq(2).html(as1);
				edit_tr1.eq(3).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
			}
			else{
				alert("Error Occured");
			}
  });
	  }
	  });
	   $("#tbl_rolemenu").on("click",".cancel",function(){
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