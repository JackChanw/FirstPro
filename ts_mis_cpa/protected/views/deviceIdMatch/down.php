<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<script type="text/javascript">
    <?php $stas = json_decode($sta, true); ?>
    var sta = <?php echo $sta; ?>;
    parent.document.getElementById('loading').style.display = 'none';
    if(sta.status == '200'){
	var n = eval('(' + decodeURIComponent(sta.msg) + ')');
	parent.document.getElementById('ts_countc').innerHTML = n.countC;
	parent.document.getElementById('ts_counta').innerHTML = n.countA;
	parent.document.getElementById('ts_countua').innerHTML = n.countUA;
	parent.document.getElementById('ts_matchc').innerHTML = n.matchC;
	parent.document.getElementById('ts').style.display = 'block';
	location.href = '<?php echo Yii::app()->createUrl('deviceIdMatch/down', array('downFileName'=>$stas['file'])) ?>';
    }else{
	alert(sta.msg); 
    }
</script>
</head>
<body>
</body>
</html>
