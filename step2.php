<?php include 'header.php';

if($_REQUEST['action_type'] == 'step2') {
	$nDemand = $_POST['nDemand'];
	$rDigit = $_POST['rDigit'];
	$tNewspaper = $_POST['tNewspaper'];
	$pnCost = $_POST['pnCost'];
	$saleRate = $_POST['saleRate'];
	$sRate = $_POST['sRate'];
}
?>

<div class="container">

	<h3>Simulation Table for Purchase of <?php echo $tNewspaper; ?> Newspapers</h3>

	<form action="final.php" method="POST">

	<div class="row">
	  <div class="col-6 col-md-6">

	  <p>Distribution of Newspaper Demanded</p>            
	  <table class="table table-bordered">
	    <thead>
	      <tr>
	        <th>Demand</th>
	        <th>Good</th>
	        <th>Fair</th>
	        <th>Poor</th>
	      </tr>
	    </thead>
	    <tbody>
	    <?php
			for($i=0, $iMaxSize=$nDemand; $i<$iMaxSize; $i++) {
		?>
	      <tr>
	        <td><input type="text" class="form-control" name="demand[]" ></td>
	        <td><input type="text" class="form-control" name="good[]" ></td>
	        <td><input type="text" class="form-control" name="fair[]" ></td>
	        <td><input type="text" class="form-control" name="poor[]" ></td>
	      </tr>
	    <?php
			}
		?>

	    </tbody>
	  </table>
	  </div>

	  <div class="col-6 col-md-6">
		  <p>Random-Digit Assignment for Type of Newsday</p>            
		  <table class="table table-bordered">
		    <thead>
		      <tr>
		        <th>Type of Newsday</th>
		        <th>Probability</th>
		      </tr>
		    </thead>
		    <tbody>
		      <tr>
		        <td>Good</td>
		        <td><input type="text" class="form-control" name="goodNewsday"></td>
		      </tr>
		      <tr>
		        <td>Fair</td>
		        <td><input type="text" class="form-control" name="fairNewsday"></td>
		      </tr>
		      <tr>
		        <td>Poor</td>
		        <td><input type="text" class="form-control" name="poorNewsday"></td>
		      </tr>
		    </tbody>
		  </table>
	  </div>

	  <div class="col-6 col-md-6 pull-right">
		  <p>Random-Digit Assignment for Type of Newsday & Demand</p>            
		  <table class="table table-bordered">
		    <thead>
		      <tr>
		        <th>Random Digit for Type of Newsday</th>
		        <th>Random Digit for Demand</th>
		      </tr>
		    </thead>
		    <tbody>
		    <?php
				for($i=0, $iMaxSize=$rDigit; $i<$iMaxSize; $i++) {
			?>
		      <tr>
		        <td><input type="text" class="form-control" name="rdNewsday[]"></td>
		        <td><input type="text" class="form-control" name="rdDemand[]"></td>
		      </tr>
		    <?php
				}
			?>
		    </tbody>
		  </table>
	  </div>

	</div>

	<input type="hidden" name="rDigit" value="<?php echo $rDigit; ?>">
	<input type="hidden" name="tNewspaper" value="<?php echo $tNewspaper; ?>">
	<input type="hidden" name="pnCost" value="<?php echo $pnCost; ?>">
	<input type="hidden" name="saleRate" value="<?php echo $saleRate; ?>">
	<input type="hidden" name="sRate" value="<?php echo $sRate; ?>">
	<input type="hidden" name="action_type" value="final">
	<input type="submit" name='submit' value="Show Result" class='btn btn-primary'/>

	</form>

</div>

</body>
</html>