<?php require_once('../Connections/zalongwa.php'); 
require_once('../Connections/sessioncontrol.php');

# include the header
// include('lecturerMenu.php');

include('timetable.php');

	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Timetable';
	$szTitle = 'Create timetable';
	$szSubSection = 'Create Timetable';
	// include("lecturerheader.php");
?>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="drag.js"></script>


<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div align select="center">
<div class="container" style="width:55%">


<?php
mysqli_select_db($zalongwa_database);
//select all academic year
$sql_ayear= "SELECT * FROM academicyear ORDER BY AYear DESC";
$result_ayear=mysqli_query($zalongwa, $sql_ayear);

// select all timetable type/category
$sql_timetablecategory= "SELECT * FROM timetableCategory";
$result_timetablecategory=mysqli_query($zalongwa, $sql_timetablecategory);

//select all programme
$sql_programme= "SELECT * FROM programme";
$result_programme=mysqli_query($zalongwa, $sql_programme);




if(isset($_POST['load'])){
	$ayear=$_POST['ayear'];
	$programme = $_POST['programme'];
	$type =$_POST['tcategory'];
 
	//header('Location: createtimetable.php?create=1&ayear='.$ayear.'&programe='.$programme.'&type='.$type);
	echo '<meta http-equiv = "refresh" content ="0; url = createtimetable.php?create=1&ayear='.$ayear.'&programme='.$programme.'&type='.$type.'">';
	exit;
}

if(!isset($_GET['create'])){
?>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">



       
<div class="form-group">
<label for="institution">Academic Year:</label>
      <select class="form-control" name="ayear">
<?php 
while($row = mysqli_fetch_array($result_ayear)){
	echo '<option value="'.$row['AYear'].'">'.$row['AYear'].'</option>';
}
?>
</select>
       </div>
       


<div class="form-group">
<label for="institution">Programme:</label>
      <select class="form-control" name="programme">
<?php 
while($row = mysqli_fetch_array($result_programme)){
	echo '<option value="'.$row['ProgrammeCode'].'">'.$row['ProgrammeName'].'</option>';
}
?>
</select>


       
<div class="form-group">
<label for="institution">Timetable Category:</label>
      <select class="form-control" name="tcategory">
<?php 
while($row = mysqli_fetch_array($result_timetablecategory)){
	echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
}
?>
</select>
</div>


<tr>
<td class="resViewhd" colspan="2" align="center"><input type="submit" name="load" value="Load"/></td>
</tr>
</table>
</form>

<?php }else {
// select all course according to criteria selected by user
	$ayear = $_GET['ayear'];
	$programme= $_GET['programme'];
	$type='';
	$ttype = $_GET['type'];
	if($_GET['type'] == 1 || $_GET['type'] == 3){
		$type.=' AND Semester = 1';
	}else if ($_GET['type'] == 2 || $_GET['type'] == 4){
		$type.=' AND Semester = 2';
	}
	  
	$title='';
	
	if($_GET['type']==1){
		$title .='SEMESTER I';
	}elseif($_GET['type']==2){
		$title .='SEMESTER II';
	}elseif ($_GET['type']== 3){
		$title .='SEMESTER I EXAMINATION';
	}elseif ($_GET['type']== 4){
		$title .='SEMESTER II EXAMINATION';
	}elseif ($_GET['type']== 5){
		$title .='SUPP/SPECIAL EXAMINATION';
	}
	
	$sql_course = "SELECT c.CourseCode,t.Capacity FROM courseprogramme as c, course as t WHERE c.CourseCode =t.CourseCode AND c.AYear='$ayear' AND c.ProgrammeID='$programme' ".$type;
	$course_result = mysqli_query($zalongwa, $sql_course);
	
	$dd = "SELECT * FROM programme WHERE ProgrammeCode='$programme'";
	$grd = mysqli_query($zalongwa, $dd);
	$pgdata = mysqli_fetch_array($grd);
	
	// select all venue
	
	$sql_venue = "SELECT * FROM venue";
	$venue_result = mysqli_query($zalongwa, $sql_venue);
	
	// select all days
$sql_days= "SELECT * FROM days";
$days_result=mysqli_query($zalongwa, $sql_days);
	
// select all lecturer
$query_lecturer = "SELECT UserName, FullName, Position FROM security WHERE Position = 'Lecturer' ORDER BY FullName";
$lecturer_result=mysqli_query($zalongwa, $query_lecturer);

//select teaching type
$sql_teaching ="SELECT * FROM teachingtype";
$teaching_result = mysqli_query($zalongwa, $sql_teaching);


//chek if action is now edit
if(isset($_GET['edit'])){
	$edit_id =$_GET['edit'];
	$sql_edit="SELECT * FROM timetable WHERE id='$edit_id'";
	$result_edit = mysqli_query($zalongwa, $sql_edit);
	$edit_data=mysqli_fetch_array($result_edit);
}

?>
<div style="width:900px; padding:10px 0px 0px 20px; font-size:20px;">
 <?php echo $pgdata['Title'].' - '.$ayear.' '.$title; ?>
</div>
<table style="width:850px;" cellpadding="0" cellspacing="0">
<tr>
<td align="center" style="border-bottom:1px solid #CCCCCC;">CourseCode</td>
<td align="center" style="border-bottom:1px solid #CCCCCC;">Time table</td>
<td align="center" style="border-bottom:1px solid #CCCCCC;">Venue Code</td>
</tr>
  <tr>
   <!-- Left side load courses -->
   <td valign="top" style="border-right:1px solid #CCCCCC ;">
   <div style="height: 500px; overflow:scroll;">
<table>
<?php 
$l=0;
while ($row = mysqli_fetch_array($course_result)) {
$div_id =str_replace(' ','_',$row['CourseCode']);
	if($l%2 == 0){

		?>
	<tr>
	<?php }?>
		<td class="item">
	<div style="display:inline;"><span style="display:block; width:100px; text-align:center; padding:5px; border:1px solid gray; margin:3px 0px 3px 0px;"><span class="cou" style="display:block;"><?php echo $row['CourseCode'];?></span><span class="coucapa" style="display:block; text-align:center;">(<?php echo $row['Capacity']; ?>)</span></span></div>
	</td>
	<?php 
	$l++;
	if($l%2 == 0){ ?>
	</tr>
<?php }
} ?>
</table>
</div>
   </td>
   
   <!-- Middle for timetable -->
   <td valign="top" style="border-right:1px solid #CCCCCC; width:600px; padding-right :20px; ">
   <div id="notification" style="padding-top:20px;"></div>
   <!--  See URL -->
   <input type="hidden" value="<?php echo $_GET['ayear']?>" id="ayear">
   <input type="hidden" value="<?php echo $_GET['programme']?>" id="programme">
   <input type="hidden" value="<?php echo $_GET['type']?>" id="type"> <!-- Timetable Category -->
   
<table  cellpadding="0" cellspacing="0" id="table_timetable">

<tr>
<td class="drop"  id="Course" title="Drag CourseCode at Left Side and Drop here">
<?php if(isset($_GET['edit'])){?>
<div style="display:inline;"><span style="display:block; width:100px; text-align:center; padding:5px; border:1px solid gray; margin:3px 0px 3px 0px;"><span class="cou" style="display:block;"><?php echo $edit_data['CourseCode'];?></span><span class="coucapa" style="display:block; text-align:center;">(<?php echo 'Check Right'; ?>)</span></span></div>
<?php }else{?>

<div style="border:1px solid #CCCCCC; padding:5px 0px 0px 5px;  height:25px;">Drag course Code and drop here</div>
<?php }?>
</td>
</tr>
<tr>
<td class="drop"   id="Venue" title="Drag Venue Code at Right Side and Drop here">
<?php if(isset($_GET['edit'])){?>
<div style="display:inline;"><span style="display:block; width:100px; text-align:center;  padding:5px; border:1px solid #D7BE93; margin:3px 0px 3px 0px;"><span class="id" style="display:block;"><?php echo $edit_data['venue'];?></span><span class="venuecapa" style="display:block;text-align:center;">(<?php echo 'check Left';?>)</span></span></div>
<?php }else{?>
<div style="border:1px solid #CCCCCC; padding:5px 0px 0px 5px;  height:25px;">Drag Venue Code  and drop here</div>
<?php }?>
</td>
</tr>
<tr>
<td><select name="teaching" id="teaching">
<option value="">Select teaching type</option>
<?php 
while ($row = mysqli_fetch_array($teaching_result)) {
  echo '<option '.( isset($_GET['edit']) ? ($row['id'] == $edit_data['teachingtype'] ? 'selected="selected"':''):'').' value="'.$row['id'].'">'.$row['name'].'</option>';
	 } ?>
</select></td>
</tr>

<tr>
<td><select name="day" id="day">
<option value="">Select Day</option>
<?php 
while ($row = mysqli_fetch_array($days_result)) {
?>
<option <?php echo (isset($_GET['edit']) ? ($edit_data['day'] == $row['id'] ? 'selected="selected"':''):''); ?> value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select></td>
</tr>
<tr>
<td><select name="start" id="start">
<option value="">Select Start time</option>
<?php if(isset($_GET['edit'])){
echo '<option selected="selected" value="'.$edit_data['start'].'">'.$edit_data['start'].':00</option>';  // hapa set value selected
}
	?>


<option value="7">7:00</option><option value="8">8:00</option><option value="9">9:00</option><option value="10">10:00</option>
<option value="11">11:00</option><option value="12">12:00</option><option value="13">13:00</option>
<option value="14">14:00</option><option value="15">15:00</option><option value="16">16:00</option>
<option value="17">17:00</option><option value="18">18:00</option><option value="19">19:00</option>
</select></td>
</tr>
<tr>
<td><select name="end" id="end">
<option value="">Select End time</option>
<?php if(isset($_GET['edit'])){
echo '<option selected="selected" value="'.$edit_data['end'].'">'.$edit_data['end'].':00</option>';  // hapa set value selected
}
	?>

<option value="8">8:00</option><option value="9">9:00</option><option value="10">10:00</option>
<option value="11">11:00</option><option value="12">12:00</option><option value="13">13:00</option>
<option value="14">14:00</option><option value="15">15:00</option><option value="16">16:00</option>
<option value="17">17:00</option><option value="18">18:00</option><option value="19">19:00</option>
<option value="20">20:00</option>
</select></td>
</tr>
<tr>
<td><select name="lecturer" id="lecturer">
<option value="">Select Lecturer Name</option>
<?php 
while ($row = mysqli_fetch_array($lecturer_result)) {
?>
<option <?php echo (isset($_GET['edit']) ? ($row['UserName'] == $edit_data['lecturer'] ? 'selected="selected"':'') : '');?> value="<?php echo $row['UserName'];?>"><?php echo $row['FullName'];?></option>
<?php } ?>
</select></td>
</tr>
<tr>
<td>
<?php if(isset($_GET['edit'])){?>

<input type="hidden" value="<?php echo $_GET['edit'];?>" name="id" id="id"/>
<input type="button" id="SAVE" value="EDIT" name="EDIT"/>
<?php } else { ?>
<input type="hidden" value="0" name="id" id="id"/>
<input type="button" id="SAVE" value="SAVE" name="SAVE"/>

<?php } ?>
</td>
</tr>
</table>
  </td>
   
   <!-- Venue -->
   
   <td valign="top" >
    <div style="height: 500px; overflow:scroll;">
  <table>
<?php 
$i=0;
$m=0;
while ($row = mysqli_fetch_array($venue_result)) {
$div_id =str_replace(' ','_',$row['VenueCode']);
	if($i%2 == 0){

		?>
	<tr>
	<?php } $m++; ?>
	<td class="item">
	<div style="display:inline;"><span style="display:block; width:100px; text-align:center;  padding:5px; border:1px solid #D7BE93; margin:3px 0px 3px 0px;"><span class="id" style="display:block;"><?php echo $row['VenueCode'];?></span><span class="venuecapa" style="display:block;text-align:center;">(<?php echo $row['VenueCapacity'];?>)</span></span></div>
	</td>
	<?php 
	$i++;
	
	if($i%2 == 0){
       
		?>
	</tr>
<?php }


} ?>
</table>
</div>
   </td>
   
  </tr>
</table>

<?php }?>
<script type="text/javascript">
//$(document).bind("contextmenu", function(e) {
  //  return false;
//});
//global variable for id of subject
var id_drag = '';
var start_time='';
$(document).ready(function(){
	$('#SAVE').click(function (e) {
   var data = { 
	course : $('#Course').find('div span span.cou').text(),
         venue : $('#Venue').find('div span span.id').text(),
         coursecapa : $('#Course').find('div span span.coucapa').text(),
         venuecapa : $('#Venue').find('div span span.venuecapa').text(),
         start : $('#start').val(),
         end : $('#end').val(),
         day : $('#day').val(),
         lecturer : $('#lecturer').val(),
         ayear : $('#ayear').val(),
         programme : $('#programme').val(),
         type : $('#type').val(),
         action:$('#SAVE').val(),
         id:$('#id').val(),
         teaching:$('#teaching').val()
   };


   $.ajax({
       type: "POST",
       url: "processtimetable.php",
       cache: false,
       data: data,
       success: function(data){
             $('#notification').html(data);
         }
   });	
         
      
      
	});




	
			$('.item div').draggable({
				revert:true,
				proxy:'clone'
			});
			$('td.drop').droppable({
				onDragEnter:function(){
					//$(this).addClass('over');
					
				},
				onDragLeave:function(){
					//$(this).addClass('over');
				},
				onDrop:function(e,source){

						$(this).html(source);
 
                
				}

			});


			$('.venue div').draggable({
				revert:true,
				proxy:'clone'
			});
			$('td.dropvenue').droppable({
				onDragEnter:function(){
					$(this).addClass('over');
					
				},
				onDragLeave:function(){
					$(this).addClass('over');
				},
				onDrop:function(e,source){

						$(this).html(source);
					   // span_value = $(this).text();
					    //span_id = $(this).find('div').attr('id');
					    //$('#tb tr td ').addClass('spandrag');
					   // $('#tb tr td div span').addClass('spandrag');
                          
 
                
				}

			});
			

			

			
		});



	</script>
	
