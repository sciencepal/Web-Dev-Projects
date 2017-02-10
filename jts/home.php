<?php 
if(!isset($_SESSION))
{
session_start();	
}

//session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/header.css" rel="stylesheet" type="text/css"></link>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"></link>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="startbootstrap/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="startbootstrap/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php include_once('header.php');?>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <!-- /.navbar-header -->
            <div align="right">
			<!--?php
             session_start();
             session_destroy();
			 ?-->
			<a href='logout.php'>LOG OUT<i class='glyphicon glyphicon-log-out'></i></a>
			</div>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <?php
							$id=$_SESSION["uid"];
							include_once('dbconnect.php');
							/*$query="SELECT * FROM jts__t_menu";
							$data=mysql_query($query);
							$menu ='';
							while($row=mysql_fetch_array($data))
							{
								$menu.="<li >"."<a href='javascript:void(0)' data_url='".$row[menu_url]."' class='demo_menu'>".$row[menu_name]."</a>"."</li>";
							}
							print $menu;
							$query="SELECT * FROM jts__t_user_role WHERE user_id='$id'";
							$data=mysql_query($query);
							$menu="";
							while($row=mysql_fetch_array($data))
							{
								$r=$row["role_id"];
								$query1="SELECT menu_id FROM jts__t_role_menu WHERE role_id='".$r."'";
								$data1=mysql_query($query1);
								while($row1=mysql_fetch_array($data1))
								{
									$r1=$row1["menu_id"];
									$query3="SELECT * FROM jts__t_menu WHERE menu_id='$r1'";
									$data2=mysql_query($query3);
									while($row3=mysql_fetch_array($data2))
									{
										$menu.="<li >"."<a href='javascript:void(0)' data_url='".$row3[menu_url]."' class='demo_menu'>".$row3[menu_name]."</a>"."</li>";
									}
								}
							}
							print $menu;*/
							$query="SELECT DISTINCT menu_id,menu_name,menu_url 
							FROM jts__t_menu WHERE menu_id IN(
                            SELECT menu_id FROM jts__t_role_menu WHERE role_id IN (
                            SELECT role_id FROM jts__t_user_role WHERE user_id='$id'
                            )
                            )";
							$data=mysql_query($query);
							$menu='';
							while($row=mysql_fetch_array($data))
							{
								$menu.="<li >"."<a href='javascript:void(0)' data_url='".$row['menu_url']."' class='demo_menu'>".$row['menu_name']."</a>"."</li>";
							}
							print $menu;
						?>                
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="section1">
						</div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>

<!--div id="footer" style="width:100%">
Copyright
</div-->

</body>
</html>

<script type="text/javascript" src="js/jquery-1.12.3.js"></script>
<script type="text/javascript">
$('.demo_menu').click(function(){
	$.post($(this).attr('data_url'),{},function(res){
		$('#section1').html(res);
	});
});
</script>