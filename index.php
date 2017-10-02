<html><head><title>Getme</title>
<link rel="apple-touch-icon" href="custom_icon.png">
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
function updateme()
{
$.getJSON( "statuswithmedia.php", function( data ) {
  $.each( data, function( key, val ) {
     $( "#"+key ).html( val );
  });
 
});

$.getJSON( "remotestatuswithmedia.php", function( data ) {
  $.each( data, function( key, val ) {
     $( "#remote"+key ).html( val );
  });
 
});

}
setInterval("updateme()",1000);


function sendtoxbmc(id)
{

$.getJSON( "sendtoxbmc_json.php?mediaid="+id, function( data ) {
  $.each( data, function( key, val ) {
     $( "#xbmc"+id ).html( val );
  });
 
});

}


function archivethis(id)
{

$.getJSON( "archivedownload.php?id="+id, function( data ) {
  $.each( data, function( key, val ) {
     //$( "#link"+id ).html( val );
  });

});

}



function linkthis(id)
{

$.getJSON( "link.php?mediaid="+id, function( data ) {
  $.each( data, function( key, val ) {
     $( "#link"+id ).html( val );
  });
 
});

}

function showurl ()
{
$( "#addurlbox" ).fadeIn();
}

</script>
<style>
body {background-color:black; color:white;font-family:"Myriad Pro",sans-serif;text-shadow:0px 0px 5px black;}
</style>
<?php
echo "</head><body>";
?><div id="addurlbox" style="display:none;position:fixed;background-color:#20202b;border-radius:25px;top: 100;left: 100;text-align:center;width: 300px; height:150px;box-shadow: 0px 0px 5px #ffffff;">
<br><br><form action="" method="post">
  URL: <input type="text" name="url" id="url"><br>
</form>
<div onclick="addurl();" style="display:inline;">Send</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div onclick='$( "#addurlbox" ).fadeOut();' style="display:inline;">Cancel</div>

</div>
<script>

function addurl () {
var url = $("input#url").val();
var dataString = 'url='+ url;

//alert (dataString);return false;
$.ajax({
  type: "POST",
  url: "addurl.php",
  data: dataString,
  success: function() {
   alert('success!');
  }
});
return false;
}
</script>
<?php
include('config.php');
exec('ls -1 '.$logpath,$array);
$i=0;
echo "<p onclick='showurl();'>Add URL</p>";
echo '<table width="309" cellspacing="0" cell-padding="0">';
echo "\n<tr  width=\"309\" height=\"33\" style=\"background-image: url('column.png');\"><td>MediaID</td><td>Local</td><td>Remote</td><td>Command</td><td>Link</td><td>Archive</td></tr>";

while ($i<count($array))
{
echo "\n<tr  width=\"309\" height=\"33\" style=\"background-image: url('row.png');\"><td><center>".$array[$i]."</center> ";
$string=exec('cat '.$logpath.$array[$i].' | grep "% " | tail -1');
preg_match('/100%|[0-9]?[0-9]%/',$string,$matches);
echo "<td id='".$array[$i]."'><center>".$matches[0]."</center></td>";
echo "<td id='remote".$array[$i]."'>N/A</td>";
if ($matches[0]=="100%") {echo " <td id=\"xbmc".$array[$i]."\" onclick=\"sendtoxbmc('".$array[$i]."')\"><center>Send</center></div> ";
echo "<td id='link".$array[$i]."' onclick=\"linkthis('".$array[$i]."')\">Link"; 
} 
else {echo " <td id='xbmc".$array[$i]."'><center><font style='color:gray'>Send</center></font></div> ";
echo "<td id='link".$array[$i]."'><font style='color:gray;'>Link</font> "; 
}
echo '</td><td onclick="archivethis('.$array[$i].')">Archive';
echo "</td></tr>";
$i++;
}
echo "</table>";
?>
</body>
</html>
