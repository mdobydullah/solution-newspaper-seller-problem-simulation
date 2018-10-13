<?php include 'header.php';

// for PHP 7.1
error_reporting(0);

if($_REQUEST['action_type'] == 'final') {
	// from first page
	$rDigit     = $_POST['rDigit'];
	$tNewspaper = $_POST['tNewspaper'];
	$pnCost     = $_POST['pnCost'];
	$saleRate   = $_POST['saleRate'];
	$sRate      = $_POST['sRate'];

	// from 2nd page
	$demand = $_POST['demand'];
	$good   = $_POST['good'];
	$fair   = $_POST['fair'];
	$poor   = $_POST['poor'];

	$rdNewsday = $_POST['rdNewsday'];
	$rdDemand  = $_POST['rdDemand'];

	$goodNewsday   = $_POST['goodNewsday'];
	$fairNewsday   = $_POST['fairNewsday'];
	$poorNewsday   = $_POST['poorNewsday'];

	// Cumulative probability
	$goodCum = $goodNewsday;
	$fairCum = $goodNewsday + $fairNewsday;
	$poorCum = $goodNewsday + $fairNewsday + $poorNewsday;

	// Random-digit assignment
	$goodMin = 1;
	$goodMax = $goodCum * 100;
	$fairMin = $goodMax + 1;
	$fairMax = $fairCum * 100;
	$poorMin = $fairMax + 1;
	$poorMax = $poorCum * 100;

	// Variable for last table
	$totalPapers = $tNewspaper;
	$totalcost   = $tNewspaper * $pnCost;
	$perProfit   = $saleRate - $pnCost;
	$salvageRate = $sRate;
	$type        = '';
	$revenue     = '';
	$maindemand  = '';
	$lostProfit  = '';
	$salvage     = '';
	$profit      = '';
}
?>

<div class="container">

	<h3>Simulation Table for Purchase of <?php echo $tNewspaper; ?> Newspapers</h3>

	<div class="row">
	  <div class="col-6 col-md-6">

  <!-- 1st table -->
	  <p>Distribution of Newspaper Demanded</p>            
	  <table class="table table-bordered">
	    <thead>
	      <tr>
	        <th rowspan="2">Demand</th>
	        <th colspan="3">Cumulative Distribution</th>
	        <th colspan="3">Random-Digit Assignment</th>
	      </tr>
	      <tr>
	        <th>Good</th>
	        <th>Fair</th>
	        <th>Poor</th>
	        <th>Good</th>
	        <th>Fair</th>
	        <th>Poor</th>
	      </tr>
	    </thead>
	    <tbody>
	    <?php
	    	$sumGood = 0;
	    	$sumFair = 0;
	    	$sumPoor = 0;
			for($i=0, $count = $rDigit;$i<$count;$i++) {
		?>
	      <tr>
	        <td><?php echo $demand[$i]; ?></td>
	        <td><?php $sumGood = $good[$i] + $sumGood; echo $sumGood; ?></td>
	        <td><?php $sumFair = $fair[$i] + $sumFair; echo $sumFair; ?></td>
	        <td><?php $sumPoor = $poor[$i] + $sumPoor; echo $sumPoor; ?></td>

	        <td>
		        <?php
		        	if($i==0) {
		        		$goodNPMin = 1;
		        	}else if($i>0) {
		        		$goodNPMin = $goodNPMax + 1;
		        	}
		        	$goodNPMax = $sumGood * 100;
		        	echo $goodNPMin . '-' . $goodNPMax;

		            $dataGood[] = array(
		                'demand' => $demand[$i],
		                'min' => $goodNPMin,
		                'max' => $goodNPMax
		            );
		        ?>
	        </td>
	        <td>
		        <?php
		        	if($i==0) {
		        		$fairNPMin = 1;
		        	}else if($i>0) {
		        		$fairNPMin = $fairNPMax + 1;
		        	}
		        	$fairNPMax = $sumFair * 100;
		        	echo $fairNPMin . '-' . $fairNPMax;

		            $dataFair[] = array(
		                'demand' => $demand[$i],
		                'min' => $fairNPMin,
		                'max' => $fairNPMax
		            );
		        ?>
	        </td>
	        <td>
		        <?php
		        	if($i==0) {
		        		$poorNPMin = 1;
		        	}else if($i>0) {
		        		$poorNPMin = $poorNPMax + 1;
		        	}
		        	$poorNPMax = $sumPoor * 100;
		        	echo $poorNPMin . '-' . $poorNPMax;

		            $dataPoor[] = array(
		                'demand' => $demand[$i],
		                'min' => $poorNPMin,
		                'max' => $poorNPMax
		            );
		        ?>
	        </td>
	      </tr>
	    <?php
			}
		?>

	    </tbody>
	  </table>
	  </div>

  <!-- 2nd table -->
	  <div class="col-6 col-md-6">
		  <p>Random-Digit Assignment for Type of Newsday</p>            
		  <table class="table table-bordered">
		    <thead>
		      <tr>
		        <th>Type of Newsday</th>
		        <th>Probability</th>
		        <th>Cumulative Probability</th>
		        <th>Random-Digit Assignment</th>
		      </tr>
		    </thead>
		    <tbody>
		      <tr>
		        <td>Good</td>
		        <td><?php echo $goodNewsday; ?></td>
		        <td><?php echo $goodCum; ?></td>
		        <td><?php echo $goodMin . '-' . $goodMax; ?></td>
		      </tr>
		      <tr>
		        <td>Fair</td>
		        <td><?php echo $fairNewsday; ?></td>
		        <td><?php echo $fairCum; ?></td>
		        <td><?php echo $fairMin . '-' . $fairMax; ?></td>
		      </tr>
		      <tr>
		        <td>Poor</td>
		        <td><?php echo $poorNewsday; ?></td>
		        <td><?php echo $poorCum; ?></td>
		        <td><?php echo $poorMin . '-' . $poorMax; ?></td>
		      </tr>
		    </tbody>
		  </table>
	  </div>
	</div>


  <!-- lat table -->
  <p>Simulation Table for Purchase of Newspaper</p>            
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Day</th>
        <th>RD for Newsday</th>
        <th>Type of Newsday</th>
        <th>RD for Demand</th>
        <th>Demand</th>
        <th>Revenue</th>
        <th>LP from Excess Demand</th>
        <th>SS of Scrap</th>
        <th>Daily Profit</th>
      </tr>
    </thead>
    <tbody>

    <?php
		$totalRevenue = '';
		$totalLP      = '';
		$totalSalvage = '';
		$totalProfit  = '';
		for($i=0, $iMaxSize=$rDigit; $i<$iMaxSize; $i++) {
	?>
      <tr>
        <td><?php echo $i+1; ?></td>
        <td><?php echo $rdNewsday[$i]; ?></td>
        <td>
        <?php
        	if($rdNewsday[$i] >= $goodMin && $rdNewsday[$i] <= $goodMax) {
        		echo "Good";
        		$type = 'good';
        	}
        	else if($rdNewsday[$i] >= $fairMin && $rdNewsday[$i] <= $fairMax) {
        		echo "Fair";
        		$type = 'fair';
        	}
        	else {
        		echo "Poor";
        		$type = 'poor';
        	}
        ?>
        </td>
        <td><?php echo $rdDemand[$i]; ?></td>
        <td>
        <?php
        	if($type=='good') {
        		foreach ($dataGood as $key => $value) {
        			if($rdDemand[$i] >= $value['min'] && $rdDemand[$i] <= $value['max']) {
        				echo $value['demand'];
        				$maindemand = $value['demand'];
        			}
				} 
        	}
        	else if($type=='fair') {
        		foreach ($dataFair as $key => $value) {
        			if($rdDemand[$i] >= $value['min'] && $rdDemand[$i] <= $value['max']) {
        				echo $value['demand'];
        				$maindemand = $value['demand'];
        			}
				} 
        	}
        	else if($type=='poor'){
        		foreach ($dataPoor as $key => $value) {
        			if($rdDemand[$i] >= $value['min'] && $rdDemand[$i] <= $value['max']) {
        				echo $value['demand'];
        				$maindemand = $value['demand'];
        			}
				} 
        	}
        ?>
        </td>
        <td>
        <?php
        	// revenue from sales
        	if($maindemand < $totalPapers) {
        		$revenue = $maindemand * $saleRate;
        		$totalRevenue += $revenue;
        		echo $revenue;
        	} else {
        		$revenue = $totalPapers * $saleRate;
        		$totalRevenue += $revenue;
        		echo $revenue;
        	}
        ?>
        </td>
        <td>
        <?php
        	// lost profit
        	if($maindemand > $totalPapers) {
        		$short = $maindemand - $totalPapers;
        		$lostProfit = $short * $perProfit;
        		$totalLP += $lostProfit;
        		echo $lostProfit;
        	}
        	else {
        		$lostProfit = 0;
        		$totalLP += $lostProfit;
        		echo '-';
        	}
        ?>
        </td>
        <td>
        <?php
        	// salvage from sale of scrap
        	if($maindemand < $totalPapers) {
        		$sv = $totalPapers - $maindemand;
        		$salvage = $sv * $sRate;
        		$totalSalvage += $salvage;
        		echo $salvage;
        	}
        	else {
        		$salvage = 0;
        		echo '-';
        	}
        ?>
        </td>
        <td>
        <?php
        	$profit =  $revenue - $totalcost - $lostProfit + $salvage;
        	$totalProfit += $profit;
        	echo $profit;
        ?>
        </td>
      </tr>
    <?php
		}
	?>
      <tr>
      	<th>Total</th>
      	<td colspan="4"></td>
      	<td><?php echo $totalRevenue; ?></td>
      	<td><?php echo $totalLP; ?></td>
      	<td><?php echo $totalSalvage; ?></td>
      	<td><?php echo $totalProfit; ?></td>
      </tr>

    </tbody>
  </table>


</div>

</body>
</html>