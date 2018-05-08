
<?php
$myfile = fopen("event.txt", "r") or die("Unable to open file!");
echo fread($myfile,filesize("event.txt"));
fclose($myfile);
?>
