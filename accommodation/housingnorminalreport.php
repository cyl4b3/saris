<?php
session_start();
header("Cache-control: private"); // IE 6 Fix. 
@$auth_level = $_SESSION['auth_level'];
@$RegNo = $_SESSION['RegNo'];
@$username = $_SESSION['username'];

@$year=$_POST['AllCriteria'];
@$hall=$_POST['Hall'];
@$all = $_POST['check'];

if(!$username){
	echo ("Session Expired, <a href=\"ReLogin.php\"> Click Here<a> to Re-Login");
	
	echo '<meta http-equiv = "refresh" content ="0; 
	url = ReLogin.php">';
	exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang=en-US>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="ZALONGWA, zalongwa, Student Information System (SIS), accommodation information system, database system, examination database system, student records system, database system">
<meta name="description" content="School Management Information System, Database System, Juma Lungo Lungo Lungo Lungo, Database System , Student Information System (SIS), Accommodation Record Keeping, Examination Results System, student Normninal Roll Database">
<meta name="rating" content="General">
<meta name="Generator" content="Macromedia Dreamweaver  UtraDev 4.1">
<meta name="authors" content="Juma Hemed Lungo">
<meta name="robots" content="all">

<meta http-equiv="Content-Language" content="pt">
<meta name="VI60_defaultClientScript" content="JavaScript">

<title>UDSM Student Information System</title>
<link rel="stylesheet" type="text/css" href="/master.css">

<style type="text/css">
<!--
.style24 {font-size: 12px}
.style34 {color: #990000}
.style35 {
	color: #993300;
	font-size: 11px;
}
a:link {
	text-decoration: none;
	color: #000099;
}
a:visited {
	text-decoration: none;
	color: #000099;
}
a:hover {
	text-decoration: underline;
	color: #CC0000;
}
a:active {
	text-decoration: none;
	color: #CC0000;
}
.style47 {font-size: small}
.style55 {font-size: 10px}
.style58 {color: #993300; font-size: 12px; }
.style59 {color: #993300}
.style60 {font-size: 11px; color: #990000;}
.style61 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style63 {font-size: 12px; color: #990000;}
.style65 {color: #990000; font-weight: bold; }
.style67 {color: #000000}
-->
</style>
</head>

<body bgcolor="#FFFFCC">
<div align="center">
  <center>
    <tr> 
      <td width="100%" height="48"></td>
    </tr>
  </center>
</div>
<div align="center">
  <center>
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#990000">
      <tr bgcolor="#99CCCC">
        <td height="69" colspan="7" align="center" valign="middle"> <img src="/images/Nkurumah.gif" width="724" height="69" align="left"></td>
      </tr>
      <tr>
        <td width="56" rowspan="5" valign="top" bgcolor="#99CCCC">
            <table width="62%" height="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFCC" bgcolor="#99CCCC">
          <tr class="style35">
            <td height="0" nowrap><div align="center" class="style47"><img src="/images/bd21312_.gif" alt="Your Profile" width="15" height="15"></div></td>
            <td nowrap></td>
            <td colspan="3" nowrap class="style58"><div align="left" class="style58"><?php print "<a href=\"housingprofile.php?username=$username\">Your Profile</a>";?><span class="style59"> <font face="Verdana">&nbsp;</font> </span></div></td>
            </tr>
			<tr class="style35">
            <td height="20" align="right" valign="middle" nowrap><div align="center" class="style47"><img src="/images/bd21312_.gif" alt="Room Application" width="15" height="15"></div></td>
            <td colspan="4" align="left" valign="middle" nowrap class="style35"><span class="style58"><?php print "<a href=\"housingroomapplication.php?username=$username\">Room Application</a>";?></span></td>
            </tr>
			<tr class="style35">
            <td height="20" align="right" valign="middle" nowrap><div align="center" class="style47"><img src="/images/bd21312_.gif" alt="Nominal Roll" width="15" height="15"></div></td>
            <td colspan="4" align="left" valign="middle" nowrap class="style35"><span class="style58"><?php print "<a href=\"housingnorminalroll.php?username=$username\">Nominal Roll</a>";?></span></td>
            </tr>
          <tr class="style35">
            <td height="20" align="right" valign="middle" nowrap><div align="center" class="style47"><img height=15 alt=Room Allocation 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></div></td>
            <td colspan="4" align="left" valign="middle" nowrap class="style35"><span class="normaltext style24"><?php print "<a href=\"housingroomallocation.php?username=$username\">Room Allocation</a>";?></span></td>
            </tr>
          
          <tr class="style35">
            <td height="20" colspan="2" align="right" valign="middle" nowrap><div align="center" class="style47"><strong><span class="style34"><img height=15 alt=Caution Fees 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></span></strong></div></td>
            <td height="20" colspan="3" align="right" valign="middle" nowrap class="style35"><div align="left" class="style24"><span class="style34"><?php print "<a href=\"housingcautionfeepaidreport.php?username=$username\">Caution Fees</a>";?></span></div></td>
            </tr>
          <tr class="style35">
            <td height="20" colspan="2" align="right" valign="middle" nowrap><div align="center" class="style47"><strong><span class="style34"><img height=15 alt=Penalty Fees 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></span></strong></div></td>
            <td height="20" colspan="3" align="right" valign="middle" nowrap class="style35"><div align="left" class="style24"><span class="style34"><?php print "<a href=\"housingcautionfeepaidpenaltyreport.php?username=$username\">Penalty Charges</a>";?></span></div></td>
            </tr>
          <tr class="style35">
            <td height="20" colspan="2" align="right" valign="middle" nowrap><div align="center" class="style47"><strong><img height=15 alt=Rent Fees 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></strong></div></td>
            <td height="20" colspan="3" align="right" valign="middle" nowrap class="style35"><div align="left" class="style24"><span class="style34"><span class="style61"><?php print "<a href=\"housingroomrents.php?username=$username\">Room Rent Fees</a>";?></span></span></div></td>
            </tr>
			<tr class="style35">
            <td height="20" colspan="2" align="right" valign="middle" nowrap><div align="center" class="style47"><strong><img height=15 alt=Suggestion Box 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></strong></div></td>
            <td height="20" colspan="3" align="right" valign="middle" nowrap class="style35"><div align="left" class="style24"><?php print "<a href=\"housingcheckmessage.php?username=$username\">Check Messages</a>";?></div></td>
            </tr>
          <tr class="style35">
            <td height="20" colspan="2" align="right" valign="middle" nowrap><div align="center" class="style47"><strong><img height=15 alt=Suggestion Box 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></strong></div></td>
            <td height="20" colspan="3" align="right" valign="middle" nowrap class="style35"><div align="left" class="style24"><?php print "<a href=\"housingsuggestionbox.php?username=$username\">Suggestion Box</a>";?></div></td>
            </tr>
           <tr class="style35">
            <td height="20" colspan="2" align="right" valign="middle" nowrap><div align="center" class="style47"><strong><img height=15 alt=Change Password Network 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></strong></div></td>
            <td height="20" align="right" valign="middle" nowrap class="style35"><div align="left" class="style24">
              <div align="left" class="style34"><?php print "<a href=\"changepassword.php?username=$username\">Change Password</a>";?></div>
                              
</div></td>
          </tr>
           <tr class="style35">
            <td height="2" nowrap><div align="center"><span class="style35"><span class="style35"><span class="style55"><span class="style55"><span class="style47"><span class="style47"><img src="/images/bd21312_.gif" alt="Sign Out" width="15" height="15"></span></span></span></span></span></span></div></td>
            <td nowrap class="style14 style9 normaltext style47"></td>
            <td colspan="3" nowrap class="style35"><div align="left" class="style24"><?php print "<a href=\"signout.php?username=$username\">Sign Out</a>";?></div></td>
            </tr>
        </table></td>
        <td><form action="/accommodation/housingroomallocationsearchreport.php" method="get" class="style24">
            <div align="right"><span class="style42"><font face="Verdana"><b>Search</b></font></span> 
              <font color="006699" face="Verdana"><b> 
              <input type="text" name="content" size="15">
              </b></font><font color="#FFFF00" face="Verdana"><b> 
              <input type="submit" value="GO" name="go">
            </b></font>            </div>
        </form></td>
        <td bgcolor="#99CCCC">&nbsp;</td>
      </tr>
      <tr>
        <td width="671" align="center" valign="top"><div align="left">
          	<?php
require_once('../Connections/zalongwa.php'); 
if ($all =='on'){
$sql = "SELECT student.Name, student.RegNo, student.Sex, student.ProgrammeofStudy, student.Faculty, student.EntryYear, student.Sponsor
FROM student
WHERE (student.EntryYear='$year') ORDER BY  student.Faculty, student.ProgrammeofStudy, student.Name";
}else{
$sql = "SELECT student.Name, student.RegNo, student.Sex, student.ProgrammeofStudy, student.Faculty, student.EntryYear, student.Sponsor
FROM student
WHERE (student.EntryYear='$year') AND (student.ProgrammeofStudy = '$hall') ORDER BY  student.Faculty, student.ProgrammeofStudy, student.Name";
}
$result = @mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());
$query = @mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());

$all_query = mysql_query($query);
$totalRows_query = mysql_num_rows($query);
/* Printing Results in html */
if (mysql_num_rows($query) > 0){
echo "Nominal Roll Report For the Year: $year";
echo "<p>Total Records: $totalRows_query </p>";
echo "<table border='1'>";
echo "<tr><td> S/No </td><td> Name </td><td> RegNo </td><td> Sex </td><td> Degree </td><td> Faculty </td><td> Sponsor </td></tr>";
$i=1;
while($result = mysql_fetch_array($query)) {
		$Name = stripslashes($result["Name"]);
		$RegNo = stripslashes($result["RegNo"]);
		$sex = stripslashes($result["Sex"]);
		$degree = stripslashes($result["ProgrammeofStudy"]);
		$faculty = stripslashes($result["Faculty"]);
		$sponsor = stripslashes($result["Sponsor"]);
			echo "<tr><td>$i</td>";
			echo "<td>$Name</td>";
			echo "<td>$RegNo</td>";
			echo "<td>$sex</td>";
			echo "<td>$degree</td>";
			echo "<td>$faculty</td>";
			echo "<td>$sponsor</td></tr>";
		$i=$i+1;
		}
echo "</table>";
}else{
echo "Sorry, No Records Found <br>";
}
mysql_close($zalongwa);
?>
		
        </div></td>
        <td width="34" bgcolor="#99CCCC">&nbsp;</td>
      </tr>
    </table>
  </center>
</div>
<div align="center">
  <center>
  </center>
</div>

</body>

</html>