<?php
$dir = '.';
include 'system.php';
$list = str_replace($dir.'/','',(glob($dir.'/*.app')));
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<title><?=$websiteTitle;?></title>
<link rel="shortcut icon" href="favicon.png?rev=<?=time();?>" type="image/x-icon">
<link href="system.css?rev=<?=time();?>" rel="stylesheet">
<?php include 'base.incl.php'; ?>
</head>
<body>
<div class='top'>
<p align="center">
<?php include 'getman.php'; ?>
</p>
</div>
<div class='panel'>
<p align="center">
<?php
foreach ($list as $key=>$value) {
    $fileContent = file_get_contents($value);
    $fileExp = explode('|[1]|', $fileContent);
    $fileTitle = $fileExp[0];
    $fileIcon = (file_exists($fileExp[1])) ? $fileExp[1] : 'sys.app.png';
    $fileLink = $fileExp[2];
?>
<img class="actionIconButton" style="height:15%;position:relative;" title="<?=$fileTitle;?>" src="<?=$fileIcon;?>?rev=<?=time();?>" onclick="<?=$fileLink;?>">
<?php } ?>
<img class="actionIconButton" style="height:15%;position:relative;" title="Update" src="sys.upd.png?rev=<?=time();?>" onclick="get('i','','from','hsis','','flossely',false);">
<img class="actionIconButton" style="height:15%;position:relative;" title="Exit" src="sys.exit.png?rev=<?=time();?>" onclick="window.location.href='../';">
</p>
</div>
</body>
</html>
