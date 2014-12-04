<?php
if (isset($_POST['isauto']) AND isset($_POST['bmaxlot']) AND isset($_POST['smaxlot']) AND isset($_POST['lot']) AND isset($_POST['feebuy']) AND isset($_POST['feesell']) AND isset($_POST['limitbuy']) AND isset($_POST['bprice']) AND isset($_POST['sprice'])){
	// Main Parameter
	$isauto = (int)$_POST['isauto'];
	$bmaxlot = (int)$_POST['bmaxlot'];
	$smaxlot = (int)$_POST['smaxlot'];
	$lot = (float)$_POST['lot'];
	$feebuy = (float)$_POST['feebuy'];
	$feesell = (float)$_POST['feesell'];
	$limitbuy = (float)$_POST['limitbuy'];

	$bprice = (int)$_POST['bprice'];
	$sprice = (int)$_POST['sprice'];
	
	if ($bprice < 500){
		$fraksi_harga = 1;
	}
	else if ($bprice > 5000){
		$fraksi_harga = 25;
	}
	else{
		$fraksi_harga = 5;
	}
	
	if ($bmaxlot <= 0){
		if ($bprice > 0 AND $lot > 0){
			$bmaxlot = floor($limitbuy / $bprice / $lot);
		}
		else{
			$bmaxlot = 0;
		}
	}
	
	// TOTAL BUY
	$_total_buy = $bprice * $bmaxlot * $lot;
	$total_buy = $_total_buy + ($_total_buy * $feebuy / 100);

	$loop = true;
	if ($isauto > 0){
		$loop2 = false;
	}else{
		$loop2 = true;
	}
	$fh = $fraksi_harga;
	
	while($loop){
		// TOTAL SELL
		if ($loop2){
			$sprice = $bprice + $fh;
			$smaxlot = $bmaxlot;
		}else{
			if ($bmaxlot <= 0){
				$smaxlot = $bmaxlot;
			}
		}
		$_total_sell = $sprice * $smaxlot * $lot;
		$total_sell = $_total_sell - ($_total_sell * $feesell / 100);
		
		// TOTAL
		$stotal = $total_sell - $total_buy;
	
		if ($stotal > 0){
			$loop = false;
		}else{
			if ($loop2){
				$fh += $fraksi_harga;
			}else{
				$loop = false;
			}
		}
	}
	
	if ($stotal > 0){
		$status = 'Untung';
		$total = '<font color="#099B09">'.number_format($stotal,0,",",".").'</font>';
	}else{
		$status = 'Rugi';
		$total = '<font color="#ff0000">'.number_format(abs($stotal),0,",",".").'</font>';
	}
	
	$result = '
	<table class="table table-striped">
	<thead>
	<tr>
		<th colspan="2">RESULT</td>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>Total Buy</td>
		<td style="text-align:right;">'.number_format($total_buy,0,",",".").'</td>
	</tr>
	<tr>
		<td>Total Sell</td>
		<td style="text-align:right;">'.number_format($total_sell,0,",",".").'</td>
	</tr>
	<tr>
		<td>Total '.$status.'</td>
		<td style="text-align:right;"><b>'.$total.'</b></td>
	</tr>
	</tbody>
	</table>';

	$data['bmaxlot'] = $bmaxlot;
	$data['sprice'] = $sprice;
	$data['smaxlot'] = $smaxlot;
	$data['stotal'] = $stotal;
	$data['result'] = $result;
	$data['status'] = 'ok';
}
else{
	$data['result'] = '<div class="alert alert-danger">Invalid parameter. Please try again!</div>';
	$data['status'] = 'error';
}
echo json_encode($data);
?>
