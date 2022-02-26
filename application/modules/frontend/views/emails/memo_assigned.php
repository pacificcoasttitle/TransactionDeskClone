<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
		<style>
			a.button {
    -webkit-appearance: button;
    -moz-appearance: button;
    appearance: button;

    text-decoration: none;
    color: initial;
		display: block;
    width: 115px;
    height: 25px;
    background: #4E9CAF;
    padding: 10px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    line-height: 25px;
}
		</style>
	</head>
 <body>
	 <div>
		 <h2>
			 <?php echo $subject; ?>
		 </h2>
	 </div>
	 <div>
		 <h4>Dear <?php echo $user_name;?></h4>
	 </div>
	 <div>
		 <?php echo $description ;?>
	 </div>
	 <div>
		 <a href="<?php echo $botton_url ?>" target="_blank" class="button">Acknowledge</a>
		 
	 </div>
 </body>
</html>
