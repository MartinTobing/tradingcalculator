<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Kalkulator Trading - Wingamers.com</title>
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
<div class="panel panel-default">
<ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#calc" data-toggle="tab">Kalkulator Trading</a></li>
  <li><a href="#settings" data-toggle="tab">Settings</a></li>
</ul>

<form name='frmCal' id="frmCal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="tab-content">
	<div class="tab-pane active" id="calc">
		<div style="padding:14px; min-height:100px;">
			<div class="form-group">
				<label for="exampleInputEmail1">Buy Price</label>
				<input type="text" class="form-control" id="bprice" placeholder="Enter Buy Price" value="0">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Buy Max Lot</label>
				<input type="text" class="form-control" id="bmaxlot" placeholder="Buy Max Lot" value="0">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Sell Price</label>
				<input type="text" class="form-control" id="sprice" placeholder="Sell Price" value="0">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Sell Max Lot</label>
				<input type="text" class="form-control" id="smaxlot" placeholder="Sell Max Lot" value="0">
			</div>
			<div id="result"></div>
			<button type="button" class="btn btn-default" id="process" name="process">Count Now!</button>
			<button type="button" class="btn btn-default" id="reset" name="reset">Reset</button>
		</div>
	</div>

	<div class="tab-pane" id="settings">
		<div style="padding:14px; min-height:100px;">
			<div class="input-group">
				<label for="lot">1 LOT</label>
			</div>
			<div class="input-group">
				<input type="text" class="form-control" id="lot" id="" value="100">
				<span class="input-group-addon">Lembar</span>
			</div>
			
			<div class="input-group" style="padding-top:10px;">
				<label for="feebuy">Fee Buy</label>
			</div>
			<div class="input-group">
				<input type="text" class="form-control" id="feebuy" value="0.2">
				<span class="input-group-addon">%</span>
			</div>
			
			<div class="input-group" style="padding-top:10px;">
				<label for="feesell">Fee Sell</label>
			</div>
			<div class="input-group">
				<input type="text" class="form-control" id="feesell" value="0.3">
				<span class="input-group-addon">%</span>
			</div>
			
			<div class="input-group" style="padding-top:10px;">
				<label for="limitbuy">Limit Buy</label>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Rp.</span>
				<input type="text" class="form-control" id="limitbuy" value="100000000">
			</div>
			<div id="result"></div>
			<div style="padding-top:10px;">
			<button type="button" class="btn btn-default" id="update" name="update" onclick="javascript:alert('This feature is disabled by Administrator!');">Update Settings</button>
			</div>
		</div>
	</div>
</div>
</form>

</div>

<script>
$(document).ready(function(){
	$('#myTab a[href="#calc"]').tab('show');

	function reset_form(){
		$('#bprice').val(0);
		$('#bmaxlot').val(0);
		$('#sprice').val(0);
		$('#smaxlot').val(0);
		$('#result').html('');
	}
	
	function post_data(auto){
		$.ajax({
			type : 'POST',
			url : 'process.php',
			dataType : 'json',
			data: {
				isauto : auto,
				lot : $('#lot').val(),
				feebuy : $('#feebuy').val(),
				feesell : $('#feesell').val(),
				limitbuy : $('#limitbuy').val(),
				bprice : $('#bprice').val(),
				bmaxlot : $('#bmaxlot').val(),
				sprice : $('#sprice').val(),
				smaxlot : $('#smaxlot').val(),
			},
			success : function(data){
				$('#bmaxlot').val(data.bmaxlot);
				$('#sprice').val(data.sprice);
				$('#smaxlot').val(data.smaxlot);
				$('#result').html(data.result);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				$('#result').html('<div class="alert alert-danger">The was an error. Please try again!</div>');
			}
		});

		return false;
	}

	$('#process').click(function() {
		post_data(1);
	});


	$('#bprice').blur(function() {
		var bprice = $('#bprice').val();
		if ( bprice > 0 ){
			post_data(0);
		}else{
			$('#bprice').val('0');
		}
	});

	$('#reset').click(function() {
		reset_form();
	});

	$('#bprice').focus(function() {
		reset_form();
		$('#bprice').val('');
	});
});
</script>
 
</body>
</html>
