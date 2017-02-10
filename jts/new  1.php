<?php 
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>

<head>
<link href="css/header.css" rel="stylesheet" type="text/css"></link>
<link href="bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"></link>
<!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php include_once('header.php');?>

<div id="nav1">
<?php
$id=$_POST["user_id"];
$pwd=$_POST["password"];
include_once('dbconnect.php');
$query="SELECT * FROM jts__t_menu";
$data=mysql_query($query);
$menu="<ul>";
while($row=mysql_fetch_array($data))
{
	$menu.='<div class="navbar-default sidebar" role="navigation">';
    $menu.='<div class="sidebar-nav navbar-collapse">';
    $menu.='<ul class="nav" id="side-menu">';
	$menu.="<li>".'<a href="home.php">'.'<i class="fa fa-dashboard fa-fw">'."</i>".$row[menu_name]."</a>"."</li>";
	$menu.="<ul>"."</div>"."</div>";
	
}
$menu.="</ul>";
print $menu;
?>
</div>

<div id="section1">
</div>

<script>
function myfunc()
{
	document.getElementById("section1").innerHTML="HI";
}
</script>

<div id="footer">
Copyright
</div>

</body>
</html>