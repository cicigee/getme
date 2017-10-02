<?php
include('config.php');
function sanitize($string) {
$match = array("/\s+/","/[^a-zA-Z0-9\-]/","/-+/","/^-+/","/-+$/");
$replace = array("-","_","-","_","_");
$string = preg_replace($match,$replace, $string);
$string = strtolower($string);
return $string;
}

$index=1000;

if (file_exists($fileindexfile))
{
$index=file_get_contents($fileindexfile);
$index=$index+1;
file_put_contents($fileindexfile,$index);

}
else
{
$index=1000;
file_put_contents($fileindexfile,$index);

}

$this_media=$index+1;
if (!(isset($_POST['url'])))
{
die("no url");
}
else
{
$url=$_POST['url'];

if (count($config['sites'])!=0)
{
foreach ($config['sites'] as $key => $value)
{ 
	if (strpos($url,'//'.$key) !== false) {
	    $url=str_replace('//'.$key,'//'.$value['username'].':'.$value['password'].'@'.$key,$url);
	}
}
}
}
$parts = explode("/",$url);
$ext=pathinfo(($parts[(count($parts)-1)]));
$ext=$ext['extension'];
$safe_name=sanitize($parts[(count($parts)-1)]).".".$ext;

$urlfilepath=$path."urls/".$this_media;
$logfilepath=$path."logs/".$this_media;
$mappingfilepath=$path."mapping/".$this_media;
$incompletefilepath=$path."incomplete/".$this_media;
file_put_contents($urlfilepath,$url);
file_put_contents($mappingfilepath,$safe_name);


exec("wget -b -i ".$urlfilepath." -O ".$incompletefilepath." -o ".$logfilepath." &");
echo "Downloading: ".$url;
echo "<a href='status.php'>Status</a>";

?>
