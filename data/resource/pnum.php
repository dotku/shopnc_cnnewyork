<?php
/**
本程序由 shopnc.club 运维舫 提供

网址：www.shopnc.club

^^^^^^^^^^^^^^^^^^^^^^^^^^^^

 */
$pnum = $_GET['pnum'];
$im = imagecreate(120, 16);
$bg = imagecolorallocate($im, 247, 247, 247);
$textcolor = imagecolorallocate($im, 101, 101, 101);
imagestring($im, 5, 0, 0, $pnum, $textcolor);
header("Content-type: image/png");
imagepng($im);
