<!DOCTYPE html>
<html lang="en">
<head>
	<title>Tip Calculator</title>
	<style>
		table, th, td{
			border: 1px solid black;
		}
	</style>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style>
		 div{
		 	padding: 80px;
		 	background-color: lightblue;
		 }
		 table{
		 	background-color: white;
		 }
	</style>
</head>
<body>

	<?php 
	// code ref http://www.w3schools.com/php/php_form_complete.asp
	// define variables and set to empty values
	$billSubtotal = $customIn = "";
	$split = 1;
	$radiobtn = 15;
	$billSubtotalErr= $customInErr = $splitErr = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// billSubtotal checking
		// use isset in stead of empty
		// http://stackoverflow.com/questions/13041989/empty-postvar-returns-true-when-the-input-value-is-0
		if (isset($_POST["billSubtotal"])) {
			$billSubtotal = $_POST["billSubtotal"];
    		// check if billSubtotal only contains numbers
			if (!is_numeric($billSubtotal) && $billSubtotal!="") {
				$billSubtotalErr = "red";
			}else{
				// check the range(can only accept positive number)
				if($billSubtotal<0){
					$billSubtotalErr = "red" ;
				}
			}
		}

		// radiobtn checking
		if (isset($_POST["radiobtn"])) {
			$radiobtn = $_POST["radiobtn"];
		}

		// custom input checking
		if (isset($_POST['customInput'])) {
			$customIn = $_POST["customInput"];
    		// check if billSubtotal only contains numbers
    		if($radiobtn == 0){ //radio btn was selected
    			if (!is_numeric($customIn) && !$customIn="") {
					$customInErr = "red";
				}else{
					// check the range(can only accept positive number)
					if($customIn<=0){
						$customInErr = "red";
					}
				}
    		}
		}

		// split persons checking
		if (isset($_POST['split'])) {
			$split = $_POST["split"];
    		// check if billSubtotal only contains numbers
			if (!is_numeric($split)) {
				$splitErr = "red";
			}else{
				// check the range(can only accept positive number)
				if(!my_is_int($split)){
					$splitErr = "red";
				}else{
					if($split<1)
						$splitErr = "red";
				}
			}
		}
	}

	function my_is_int($var) {
		$tmp = (int) $var;
		if($tmp == $var)
			return true;
		else
			return false;
	}
?>
<div>
	<form method="post">
	<table class="table table-hover" style="width: 20%">
		<tr>
			<th style="text-align: center;">Tip Calculator</th>
		</tr>
		<tr>
			<td style ="background-color:<?php echo $billSubtotalErr; ?>">
				Bill subtotal: $ <input type="text" size = "10px" name="billSubtotal" value="<?php echo $billSubtotal; ?>">
			</td>
		</tr>
		<tr>
			<td>Tip percentage:</td>
		</tr>
		<tr>
			<td style="text-align: center;">
				<?php
					// radio button
				for ($i=2; $i <=4 ; $i++) { 
					if($radiobtn == $i*5)
						echo '<input type="radio" name="radiobtn" checked="checked" value="'.($i*5).'"'.">\t".($i*5)."%\t";
					else{
						echo '<input type="radio" name="radiobtn" value="'.($i*5).'"'.">\t".($i*5)."%\t";	
						
					}
				}
				?>
			</td>
		</tr>
		<tr style ="background-color:<?php echo $customInErr; ?>">
			<td style="text-align: center;" >
				<?php
				// customInput
				if($radiobtn==0){
					echo '<input type="radio" name="radiobtn" checked="checked" value="0">';
				}else{
					echo '<input type = "radio" name = "radiobtn">';
				}
				echo ' Custom: <input type="text" name="customInput" size="6px" value="'.$customIn.'"> %';
				?>
			</td>
		</tr>
		<tr>
			<td style ="background-color:<?php echo $splitErr; ?>">
				Split: <input type="text" name="split" size="2px" value="<?php echo $split; ?>"> person(s)
			</td>
		</tr>
		<tr>
			<td style="text-align: center;">
				<input type="submit" value="submit">
			</td>
		</tr>
		<tr>
			<?php  
				// check input specified
			if(isset($billSubtotal) && $billSubtotal>0 && isset($radiobtn)){
				$outString = "";
				if($radiobtn!=0 && $split>=1){
					// 10, 15, 20 %
					$outString = "<td>Tip: $".($billSubtotal/100*$radiobtn)."<br>Total: $".($billSubtotal*(($radiobtn/100)+1));
					// split the bill
					if($split>1){
						$outString = $outString."<br>Tip each: $".(floor(($billSubtotal/100*$radiobtn/$split)*100)/100)."<br>Total each: $".(floor($billSubtotal*(($radiobtn/100)+1)/$split*100)/100);
					}
				}else{
					// custom input
					if($customIn>0 && $split>=1){
						$outString = "<td>Tip: $".($billSubtotal/100*$customIn)."<br>Total: $".($billSubtotal*(($customIn/100)+1));
						// split the bill
						if($split>1){
							$outString = $outString."<br>Tip each: $".(floor($billSubtotal/100*$customIn/$split*100)/100)."<br>Total each: $".(floor($billSubtotal*(($customIn/100)+1)/$split*100)/100);
						}
					}
					
				}
				$outString = $outString."</td>";
				echo $outString;
			}
			?>
		</tr>
	</table>	
	</form>
</div>




</body>
</html>