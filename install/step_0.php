<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $html_title;?></title>
<link href="css/install.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../data/resource/js/jquery.js"></script>
<link href="../data/resource/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../data/resource/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="../data/resource/js/jquery.mousewheel.js"></script>
</head>

<body>
<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php echo $html_header;?>
<div class="main">
  <div class="text-box" id="text-box">
    <div class="license">
      <h1>运维舫电商系统安装协议</h1><br/>
      <p class="p_center">感谢你选择运维舫电商系统。本系统由运维舫根据网域天创版本所改进版本！只用于学习交流使用。</p><br/><br/><br/><br/><br/><br/><br/>
      <p align="right">运维舫技术交流中心</p>
    </div>
  </div>
  <div class="btn-box"><a href="index.php?step=1" class="btn btn-primary">同意协议进入安装</a><a href="javascript:window.close()" class="btn">不同意</a></div>
</div>
<div class="footer">
 <h6><a href="http://www.shopnc.club" target="_blank">程序来源于 shopnc.club</a></h6>
</div>
<script type="text/javascript">
$(document).ready(function(){
	//自定义滚定条
	$('#text-box').perfectScrollbar();
});
</script>
</body>
</html>
