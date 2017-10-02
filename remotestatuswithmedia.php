<?php
include('config.php');
exec('ls -1 '.$logpath,$array);
$i=0;

if (isset($config['archivehost'])){
exec('ssh '.$config['archivehost'].' ./drwlist',$array2);

$x=0;
while ($x<count($array2))
{
$interimarray=explode(' ',$array2[$x]);
$filename=$interimarray[0];
$size=$interimarray[1];
$finalarray[$filename]=$size;
$x++;
}

while ($i<count($array))
{
$fileinquestion=$array[$i];
//$remote=exec('ssh root@caixapurpura "stat -t /storage/'.$array[$i].'"');
if (isset($finalarray[$fileinquestion]))
{
$local= exec('stat -t '.$incompletepath.$array[$i]);

$remotearray[1]=$finalarray[$fileinquestion];
$localarray=explode(" ",$local);

$percentage=(int)(($remotearray[1]/$localarray[1])*100)."%";
//echo $localarray[1]."/".$remotearray[1]." ".$percentage."%";
}
else{ $percentage="ERROR";}

$json[($array[$i])]=$percentage;


$i++;
}
echo json_encode($json);
}
?>
