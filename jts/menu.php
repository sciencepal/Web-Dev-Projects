<?php
session_start();
include_once('dbconnect.php');
$query="SELECT menu_id,menu_name,menu_desc,menu_url,act FROM jts__t_menu";
$data=mysql_query($query);
$cont="<h3 align='center'>MENU</h3><br/>";
$cont.= "<table border=1 id='tbl_menu' align='center' class='table table-striped table-bordered table-hover'>";
$cont.= "<tr>";
$cont.= "<th>MENU NAME</th>";
$cont.= "<th>MENU DESCRIPTION</th>";
$cont.= "<th>MENU URL</th>";
$cont.= "<th>STATE</th>";
$cont.= "<th>ACTION</th>";
$cont.= "</tr>";
$cont.= "<tr>";
$cont.= "<td align='center'><input type='text' name='menu_name' id='mn' placeholder='MENU NAME'></td>";
$cont.= "<td align='center'><textarea type='text' name='menu_desc' id='md' placeholder='MENU DESCRIPTION'></textarea></td>";
$cont.= "<td align='center'><input type='text' name='menu_url' id='mu' placeholder='MENU URL'></td>";
$cont.= "<td align='center'><select name='menu_stat' id='act1'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select></td>";
$cont.= "<td align='center'><input type='button' id='add' value='Add' class='btn btn-primary'></td>";
$cont.= "</tr>";
while($row=mysql_fetch_array($data))
{
	$cont.= "<tr>";
	$cont.= "<td align='center'>".$row["menu_name"]."</td>";
	$cont.= "<td align='center'>".stripslashes($row["menu_desc"])."</td>";
	$cont.= "<td align='center'>".$row["menu_url"]."</td>";
	$cont.= "<td align='center'>".$row["act"]."</td>";
	$cont.= "<td align='center'><input type='button' data='".$row[menu_id]."' class='demo_edit btn btn-primary' value='Edit'></td>";
	//<a href='javascript:void(0);' data='".$row[menu_id]."'><i class='fa fa-pencil fa-fw'></i></a></td>";
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
	if($("#mn").val()=='' || $("#md").val()=='' || $("#mu").val()=='' || $("#act1").val()==''){
		alert("All fields are required!!!");
		return false;		
	}else{
		$.post("menuadd.php",{
			'menu_name':$("#mn").val(),
			'menu_desc':$("#md").text(),
			'menu_url':$("#mu").val(),
			'menu_stat':$("#act1").val()}
			,function(res){
				if(res!='0'){
					var  new_tr = "<tr>";
						 new_tr +="<td align='center'>"+$('#mn').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#md').text()+"</td>";
						 new_tr +="<td align='center'>"+$('#mu').val()+"</td>";
						 new_tr +="<td align='center'>"+$('#act1').val()+"</td>";
						 new_tr +="<td align='center'><input type='button' value='Edit' class='demo_edit btn btn-primary'></td>";
						 new_tr +="</tr>";
					$('#tbl_menu').append(new_tr);
					$("#mn").val('');
					$("#md").val('');
					$("#mu").val('');
					$("#act1").val('Active');
				}else{
					alert("An error occured.");
				}
			});		
	}

});
 
 $("#tbl_menu").on("click",".demo_edit",function(){
	 var edit_tr=$(this).closest('tr').find('td');	 
	 var menu_name=edit_tr.eq(0).html();
	 var menu_desc=edit_tr.eq(1).html();
	 var menu_url=edit_tr.eq(2).html();
	 var menu_stat=edit_tr.eq(3).html();
	 var menu_id=$(this).attr('data');
	 
	 edit_tr.eq(0).html('<input type="text" class="text_box" value="'+menu_name+'" />');
	 edit_tr.eq(1).html('<textarea class="text_box">'+menu_desc+'</textarea>');
	 edit_tr.eq(2).html('<input type="text" class="text_box" value="'+menu_url+'" />');
	 edit_tr.eq(3).html("<select name='act' class='sel_act'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select>");
	 edit_tr.eq(3).find('.sel_act').val(menu_stat);
	 edit_tr.eq(4).html('<input type="button" value="Update" data_id="'+menu_id+'" class="update btn btn-primary"><input type="button" value="Cancel" data_id="'+menu_id+'" dn="'+menu_name+'" dd="'+menu_desc+'" du="'+menu_url+'" da="'+menu_stat+'" class="cancel btn btn-danger">');
	 
 });
 
   $("#tbl_menu").on("click",".update",function(){
	  var mi1=$(this).attr('data_id');
	  var edit_tr1=$(this).closest('tr').find('td');
	  var mn1=edit_tr1.eq(0).find('.text_box').val();
	  var md1=edit_tr1.eq(1).find('.text_box').val();
	  var mu1=edit_tr1.eq(2).find('.text_box').val();
	  var ms1=edit_tr1.eq(3).find('.sel_act').val();
	  if(mn1=='' || md1=='' || mu1=='' || ms1=='')
	  {
		alert("All fields are required!!!");
		return false;		
	  }
	  else{
		  //alert("all values present");
	        $.post("menuedit.php",{
		    'menu_id':mi1,
			'menu_name':mn1,
			'menu_desc':md1,
			'menu_url':mu1,
			'menu_stat':ms1}
			,function(res){
			if(res!=0)
			{
				edit_tr1.eq(0).html(mn1);
				edit_tr1.eq(1).html(md1);
				edit_tr1.eq(2).html(mu1);
				edit_tr1.eq(3).html(ms1);
				edit_tr1.eq(4).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");
			}
			else{
				alert("Error Occured");
			}
  });
	  }
	  });
	  
	   $("#tbl_menu").on("click",".cancel",function(){
		   var con=confirm("Are you sure to cancel?");
		  if(con){
			var mi1=$(this).attr('data_id');
			  var edit_tr1=$(this).closest('tr').find('td'); 
			  edit_tr1.eq(0).html($(this).attr('dn'));
			  edit_tr1.eq(1).html($(this).attr('dd'));
			  edit_tr1.eq(2).html($(this).attr('du'));
			  edit_tr1.eq(3).html($(this).attr('da'));
			  edit_tr1.eq(4).html("<input type='button' value='Edit' class='demo_edit btn btn-primary'>");  
		  } 
		});
 </script>
 </body>
 </html>
 <?php 
 /*make a class for every text box.find the class using find function.then find the value using .val()*/
 ?>
	
