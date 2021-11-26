<!DOCTYPE html>
<html>
<head>
	<title>**</title>
	<style type="text/css">

	   	body {background-color: #000;}
	   	.container { width:max-content; }
		


		.tv_b, .tv_s {   }
		.tv_b {color: #8fbb77; }
		.tv_s {color: #a04b4b; }
		.ts_b {color: #8fbb77; }
		.ts_s {color: #a04b4b; }

		.full_b {background-color: #6b7a1259;}
		.full_s {background-color: #914b3e52;}



		.tv_b, .tv_s, .ts_b, .ts_s, .price { width: 50px; height: 10px;  font-size: 10px; text-align: left; margin:0 1px 1px 0; font-family: arial;}
		.tv_b, .ts_b{ float:left; }
		.tv_s, .ts_s{ float:right; }

		.ts_b, .ts_s {width: 65px}


		.tvb_b, .tvb_s { max-width: 70px; height: 5px; width: 0;}
		.tvb_b {background-color: #2c3815;}
		.tvb_s {background-color: #352123;}
		.tvb_row { margin:0 1px 1px 0;}



		.price {color:#d0d0d0;}

		#total > div {float:left;}
		.titleCol {text-align: center; color:#d0d0d0;}

		.tickerB { color: #000; background-color: #8fbb77; }
		.tickerS {color: #000; background-color: #a04b4b;}

		.afp_b { font-size: 8px; color:#4b5f40; }
		.afp_s { font-size: 8px; color:#5d3e3e; }

		.gap_b, .gap_s { width: inherit; height: inherit; display: flex; align-items: center; background-color: #5b5244; position: absolute; opacity: 0.6;}
		.gap_b_op {width: 100%; height: 2px; background-color: #839911;}
		.gap_b_cl {width: 100%; height: 2px; background-color: #839911;}
		.gap_s_op {width: 100%; height: 2px; background-color: #e82548;}
		.gap_s_cl {width: 100%; height: 2px; background-color: #e82548;}




	</style>





	<script src="jq.js"></script>

	<?php require('_helper21_js.php'); ?>
	<?php require('_exchanges_js.php'); ?>
	<script type="text/javascript">


	

	

	$(document).ready(function(){


		displayCsv()
	
    })
		
		





		


	</script>
</head>
<body>

<div class="container">
	
<div id="total">
	

</div>
</div>

</body>
</html>