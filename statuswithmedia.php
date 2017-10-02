<?php
include('config.php');
exec('ls -1 '.$logpath,$array);
$i=0;
while ($i<count($array))
{
$string=exec('cat '.$logpath.$array[$i].' | grep "% " | tail -1');
preg_match('/100%|[0-9]?[0-9]%/',$string,$matches);
if (isset($array[$i])){
$json[($array[$i])]=$matches[0];
}
$i++;
}
echo json_encode($json);
?>
