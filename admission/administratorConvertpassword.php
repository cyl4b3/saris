<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Plicy Setup';
	$szSubSection = 'Encode Password';
	$szTitle = 'Encode User Passwords';
	include('admissionheader.php')
?>
<?php
# get all users
$quser="SELECT password, RegNo FROM security ORDER BY RegNo";	
$dbuser = mysqli_query($quser,$zalongwa) or die("No Single User");
	
	while($row_user = mysqli_fetch_array($dbuser)){
		$regno= $row_user['RegNo'];
		$password= $row_user['password'];
		
		// Generate jlungo hash
		$hash = "{jlungo-hash}" . base64_encode(pack("H*", sha1($password)));
					
		//Update security
		$sql = "UPDATE security SET password='$hash' WHERE RegNo = '$regno'";
		$query = mysqli_query($sql,$zalongwa) or die("Cannot query the database.<br>");
		
		echo $regno.' Password Ecoded<br>';
}
?>
