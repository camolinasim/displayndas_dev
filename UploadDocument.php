<?php
echo '<form method="post" id= "SelectionForm" name= "SelectionForm" target="_blank" action="UploadFile.php?docket='.$_GET["docket"].'" enctype="multipart/form-data">';
?>	

 <br>File to upload <input name="fileToUpload" type="file" id='fileToUpload' STYLE="width: 600px;" onchange="document.getElementById('Submit2').disabled=false;">
 <br>
 <?php
 //echo 'Subrecipient: <input type="text" name="subrecipient" value="'.$_GET["subrecipient"].'"><br>';
 echo 'Docket: '.$_GET["docket"].'<br><br>'; 
 ?> 
            
<input name="Submit2" id="Submit2" type="submit" value="Upload" disabled>
<input name="Clear" type="reset" value="Clear">


 </form>

<dlcalendar click_element_id="img_1"
            input_element_id="input_6"
            navbar_style="background-color: lightgrey; color:black;"
            daybar_style="background-color: lightgrey; font-family: Courier; color:white;"
            tool_tip="Click to choose date"></dlcalendar>

<dlcalendar click_element_id="img_2"
            input_element_id="input_7"
            navbar_style="background-color: lightgrey; color:black;"
            daybar_style="background-color: lightgrey; font-family: Courier; color:white;"
            tool_tip="Click to choose date"></dlcalendar>

<script type="text/javascript" language="javascript"  src="dlcalendar.js"></script>
 

