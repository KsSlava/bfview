<html>
	<title>wss</title>
	<head>
	<script src="jq.js"></script>
	  <script src="pusher.js"></script>
    <script src="papaparse.js"></script>
    <script src="helper.js"></script>
    
    <script src="ws.js"></script>
    <?php include('historyData.js.php'); ?>


    <style type="text/css">
    	body {background-color: /*#272822*/ #000; }

    	 .t {display: table; float: left;     font-size: 12px;   font-family: arial; color: #868686;}
    	 .r {display: table-row;} 
    	 .c {display: table-cell; padding:2px;}


    	.statContainer {display: none; position: fixed; z-index: 5000;}

	    #ptContainer{ /*width: 100%;*/ display: inline-flex;}
		.ptCanvas { /*border-right: 1px solid #0d0c0c;*/ }

		#vContainer{width: 100%; display: flex; position: absolute; bottom: 0;}
		.vCanvas { border-right: 1px solid #0d0c0c;}

			#cursorH, #cursorV  { background-color: #1a2f5f; position: fixed; display: none; }
			#cursorH{width: 100%; height: 1px;}
			#cursorV{width: 1px; height: 100%;} 
			#cursorData {width: 150px; /*height: 20px;*/ position: fixed; font-family: arial; font-size: 12px;} 
			#cursorData2 {width: 150px; height: 45px; position: fixed; font-family: arial; font-size: 12px;} 
			#cursorData2{color:#948d8d;}
			#cursorData span {margin-right: 10px;}
			.cdPrice{width: 50px; }
			.cdVol{width: 50px;}
			.cdDate{font-size: 10px;}


			#wssStatus{width: 10px; height: 10px; background-color: #f90101; position: fixed; color:#000; font-size: 10px;} 

			#clusterContainer { position:absolute; width:25000px; background-color: #1b262d; font-family: arial; font-size: 8px; color: #868686; } 
			.clusterCol > div{/*border-bottom: 1px solid #000;*/ display: flex; height: 10px;}
			.clusterCol{float: left; margin-right: 5px;}

			.clScale > div > div{ width: 40px; height: 11px; float: left; background-color: #000;
    border: 1px solid #000;}
			.clb{border:1px solid; border-color:#1b262d; color:#7faa16; float: left; width: 26px; /*height: 9px;*/ }
			.cla{border:1px solid; border-color:#1b262d; color:#e75656; width: 26px; /*height: 9px;*/ }

			/*vol line*/
			.volLineBox {width: 200px; }
			.vlb, .vla {height: 4px; width: 0;}
			.vlb {background-color:#059007; }
			.vla {background-color:#b10606;}


			/*t3*/

			#t3_left{width: 700px; height: 200px;  background-color:#000;overflow-y: scroll; }
			#t3_left > div {display: table-row;}
			#t3_left > div > div { display: table-cell; /*border: 1px solid #000;*/ font-size: 11px; font-family:arial; padding: 0 5px 0 0; color: #9b8e8e;}
			/* width */
#t3_left::-webkit-scrollbar {
  width: 10px;
}

/* Track */
#t3_left::-webkit-scrollbar-track {
  border: 1px solid #332d2d; 
}

/* Handle */
#t3_left::-webkit-scrollbar-thumb {
  background: #736868; 
}

/* Handle on hover */
#t3_left::-webkit-scrollbar-thumb:hover {
  background: #bbbaba; 
}

/*v4*/
#v4Container table {color: #909591c7; font-family: arial;}


.ordTot {padding-left: 5px;}
.ordTotА {padding-left: 5px;}

.ordTotB_p1, .ordTotB_p2, .ordTotB_p3,
.ordVolB_p1, .ordVolB_p2, .ordVolB_p3,
.ordSumB_p1, .ordSumB_p2, .ordSumB_p3 {padding-left: 15px;}

.ordTotA_p1, .ordTotA_p2, .ordTotA_p3,
.ordVolA_p1, .ordVolA_p2, .ordVolA_p3,
.ordSumA_p1, .ordSumA_p2, .ordSumA_p3 {padding-left: 5px;}

.ordVol, .ordSum {padding-left: 20px;}
.ordVolА, .ordSumА {padding-left: 5px;}


    </style>

	</head>

	<body>
		<div id="wssStatus"></div>
	<div class="statContainer">
<!-- 		<div class="t">
			<div class="r">
				<div class="c"></div>
				<div class="c">BUY</div>
				<div class="c">SEll</div>
				<div class="c">H</div>
				<div class="c" id="dayHigh"></div>
			</div>
			<div class="r">
				<div class="c">price</div>
				<div class="c" id="buyPrice"></div>
				<div class="c" id="sellPrice"></div>
				<div class="c">L</div>
				<div class="c" id="dayLow"></div>
			</div>
			<div class="r">
				<div class="c">vol</div>
				<div class="c" id="tBuyVol"></div>
				<div class="c" id="tSellVol"></div>
				<div class="c" >%</div>
				<div class="c" id="priceDay"></div>
			</div>
			<div class="r">
				<div class="c">sum</div>
				<div class="c" id="tBuySum"></div>
				<div class="c" id="tSellSum"></div>
			</div>
			<div class="r">
				<div class="c">orders</div>
				<div class="c" id="b"></div>
				<div class="c" id="s"></div>
				<div class="c" ></div>
			</div>
			<div class="r">
				<div class="c">dV/dS</div>
				<div class="c" id="dVol"></div>
				<div class="c" id="dSum"></div>
				<div class="c" ></div>
			</div>
			<div class="r">
				<div class="c">lastSize</div>
				<div class="c" id="lastBidVol"></div>
				<div class="c" id="lastAskVol"></div>
				<div class="c" ></div>
			</div>
		</div>
 -->
	</div>

	<div id="ptContainer">
			<div id="cursorH"></div>
		    <div id="cursorV"></div>
		    <div id="cursorData"></div>
		    <div id="cursorData2"></div>
	</div>

	<div id="vContainer"></div>

	<div id="clusterContainer">

	</div>

	<div id="v4Container">
		<table>
			
		</table>
	</div>


	
   
	<script src="priceTicker.v2.js"></script>
	<?php include('volTicker.v2.js.php'); ?>
	<script src="cursorTicker.js"></script>

	<?php include('cluster.js.php'); ?>

	<script src="t3.js"></script>
	<?php include('t4.js.php'); ?>
</body>
	

	


</html>

