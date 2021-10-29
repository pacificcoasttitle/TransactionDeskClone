<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	
	<link rel="stylesheet" href="<?php echo base_url('assets/frontend/css/label/style.css');?>">

</head>

<body>
    <?php foreach($pdfInfos as $pdfInfo) {?>
        <div class="label">
            <span style="margin-left:12px;"><?php echo $pdfInfo['line_1'];?></span><br>
            <span style="margin-right:12px;"><?php echo $pdfInfo['line_2'];?></span><br>
            <span style="margin-right:24px;"><?php echo $pdfInfo['line_3'];?></span><br>
        </div>
    <?php } ?>
	
</body>

</html>
