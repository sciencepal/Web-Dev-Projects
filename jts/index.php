<?php
session_start();
if(isset($_SESSION['uid']) && $_SESSION['uid']!='')
{
	header("Location:home.php");
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/header.css" rel="stylesheet" type="text/css"></link>
<link href="bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"></link>
</head>

<body>
<div class="content">
	<?php include_once('header.php');?>

	<div id="section">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">LOG-IN</h3>
					</div>
					<div class="panel-body">
					<span id="error_log" style="display:none;"></span>
					<form method="POST" id="login_frm" name="frm_login">
						<div class="form-group">
						 <label>User ID:</label>
						 <input class="form-control" type="text" name="user_id" id="uid" placeholder="User Name" size="30">
						 
						 </div>
						 <div class="form-group">
						 <label>Password:</label>
						 
						 <input class="form-control" type="password" name="password" id="pwd" placeholder="Password" size="30">
						</div>
						<div class="form-group">
						 <input type="button" id="btn" class="btn btn-lg btn-success btn-block" value="Submit">
						 </div>

					</form>
					</div>
				</div>
			</div>
		</div>
		
		
		
	</div>
	
	


	<div id="footer">
	Copyright
	</div>
</div>
</body>
</html>
<script type="text/javascript" src="js/jquery-1.12.3.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
$("#btn").click(function(){
	var x= validate();
	if(x){
		var url="login1.php";
		$.post(url,{'user_id':$("#uid").val(),'password':$("#pwd").val()},function(res){
			if(res=='1'){
				
				$('#error_log').css('display','none');
				$('#error_log').html('');
				window.location.href='home.php';
			}else{
			
				$('#error_log').css('display','block');
				$('#error_log').html("<font class='errcls' color='red'>Invalid Credential!!!</font>");
			}
		});
	}
});
    function validate(){
        var validator = $('#login_frm').validate({
            rules:{
                'user_id':{
                    required : true,
                },
                'password':{
                    required :true,
                }
            },
            messages:{
                'user_id':{
                    required:"<font class='errcls' color='red'>*Username required.</font>"
                },
                'password':{
                    required :"<font class='errcls' color='red'>*Password required.</font>"
                }
            },
			errorElement: "div",
			errorPlacement:function(error,element){
				error.insertAfter(element)
			}
						
        });
        x=validator.form();
return x;
    }
	
</script>

