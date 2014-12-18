<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
    </head>
    <body>
		<?php
			$raw_date = '10/25/2014 10:00 AM';
			// to disregard that PM escape it in the format
			$new_date = DateTime::createFromFormat('m/d/Y g:i a', $raw_date);
			echo $new_date->format('Y-m-d H:i:s'); // 2014-10-25 14:00:00
		?>
    </body>
</html>