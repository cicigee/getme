<?php
include('config.php');
if (isset($_GET['mediaid'])){
$mediaid=$_GET['mediaid'];

$filename=file_get_contents($mappingpath.$mediaid);
//echo $filename;
$execute='ln -s '.$incompletepath.$mediaid.' '.$archivepath.'['.$_GET['mediaid'].']'.$filename;

exec($execute,$array,$exitcode);
if ($exitcode==0)
{
$errorarray['status']="[linked]"; echo json_encode($errorarray);
}
else
{$errorarray['status']="[failed to link]"; echo json_encode($errorarray);
}

}
else
{$errorarray['status']="???"; echo json_encode($errorarray);}
?>
