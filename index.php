<?php
$dir = '.';
$list = str_replace($dir.'/','',(glob($dir.'/*.{app,pkg}', GLOB_BRACE)));
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<title>HSIS</title>
<link rel="shortcut icon" href="favicon.png?rev=<?=time();?>" type="image/x-icon">
<style>
@font-face {
    font-family: "libsans";
    src: url("libsans.ttf");
}
body {
    background-color: #dcdad5;
    color: #000;
    font-family: "libsans";
    font-size: 14pt;
}
input, select {
    background-color: #fff;
    color: #000;
    font-family: "libsans";
    font-size: 14pt;
}
.top {
    border: none;
    position: absolute;
    width: 98%;
    height: 15%;
    top: 0%;
}
.panel {
    border: none;
    position: absolute;
    width: 96%;
    height: 82%;
    top: 15%;
    overflow-y: scroll;
}
.actionButton {
    background-color: #fff;
    color: #000;
    font-size: 16pt;
    position: relative;
}
</style>
<script src="jquery.js"></script>
<script>
function get(key, pkg, repo, user) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            document.location.reload();
        }
    }
    xmlhttp.open("GET","get.php?key="+key+"&pkg="+pkg+"&repo="+repo+"&user="+user,false);
    xmlhttp.send();
}
</script>
</head>
<body>
<div class='top'>
<p align="center">
<select id="enterKey" onchange="
var curSys = getButton.name;
var keyVal = enterKey.options[enterKey.selectedIndex].value;
if (keyVal == 'i') {
    enterPkg.value = 'from';
    enterRepo.value = '';
    enterUser.value = '';
} else if (keyVal == 'r') {
    enterPkg.value = curSys;
    enterRepo.value = '';
    enterUser.value = '';
} else if (keyVal == 'd') {
    enterPkg.value = '';
    enterRepo.value = 'from';
    enterUser.value = 'here';
}">
<option value='i'>Install</option>
<option value='r'>Replace</option>
<option value='d'>Remove</option>
</select>
<input type="text" id="enterPkg" style="width:20%;" placeholder="Package" value="from">
<input type="text" id="enterRepo" style="width:20%;" placeholder="Repo" value="">
<input type="text" id="enterUser" style="width:20%;" placeholder="User" value="">
<input id='getButton' name="<?=file_get_contents('system.info');?>" type="button" class="actionButtonGreen" onclick="get(enterKey.options[enterKey.selectedIndex].value,enterPkg.value,enterRepo.value,enterUser.value);" value="GET">
</p>
</div>
<div class='panel'>
<p align="center">
<?php
foreach ($list as $key=>$value) {
    $fileExt = pathinfo($value, PATHINFO_EXTENSION);
    if ($fileExt == 'app') {
        $fileContent = file_get_contents($value);
        $fileExp = explode('=||=', $fileContent);
        $fileTitle = $fileExp[0];
        $fileIcon = (file_exists($fileExp[1])) ? $fileExp[1] : 'sys.app.png';
        $fileLink = $fileExp[2];
    } elseif ($fileExt == 'pkg') {
        $packageID = basename($value, '.pkg');
        $fileTitle = 'Remove: '.$packageID;
        $fileIcon = 'sys.pkg.png';
        $fileLink = "get('d', '".$packageID."', 'from', 'here');";
    }
    
?>
<img style="height:15%;position:relative;" title="<?=$fileTitle;?>" src="<?=$fileIcon;?>?rev=<?=time();?>" onclick="<?=$fileLink;?>">
<?php } ?>
</p>
</div>
</body>
</html>
