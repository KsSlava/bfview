<?php 

set_time_limit(0);


$start = '11-03-2019'; 
$end   = '12-03-2019'; 
$pair = 'tBTCUSD';

if($_POST['do']=="api"){

	$start = $_POST['start'];
	$end   = $_POST['end'];
	$pair  = 't'.strtoupper($_POST['symbol']);

}




       



$start = strtotime($start." UTC");
$end = strtotime($end." UTC");




 


$returnCsv = '';

$data = array(); 
$countSave = 0; 
$countData = 0;

$stop = 1;

$fileName = gmdate('d-m-Y', $start).'---'.gmdate('d-m-Y', $end).'---'.substr($pair, 1).'.csv';

if(strlen($start)<13){ $start = $start.'000';}
if(strlen($end)<13){ $end = $end.'000';}



while($stop>0){


	if($countSave>0){$start=$et;}


	$str =  file_get_contents('https://api.bitfinex.com/v2/trades/'.$pair.'/hist?start='.$start.'&sort=1&limit=4000');



	$out = json_decode($str, true);

	if(count($out)>=5){

		

		$endTimestamp =  end($out);
		$et           =  $endTimestamp[1];


		// if($countSave==0) {

		// 	$csv = 'Timestamp,TradeId,Price,Amount,Type'."\n";

		// 	$countSave++;  

		// }else{

		// 	$csv = ""; 
		// }

        $countSave++;  
		$csv = ""; 
		//$dtr = array_reverse($out); 
		foreach ($out as $dt) {

			$id        = $dt[0]; 
			$timestamp = substr($dt[1], 0, -3);
			$vol       = $dt[2]; 
			$price     = $dt[3];

			if($vol<0){$type="sell";}else{$type="buy";}

			$csv .= $timestamp.','.$id.','.$price.','.abs($vol).','.$type."\n";	

		}




		if($et<$end){

			
           if($_POST['do']=="api"){

           		$returnCsv .= $csv; 

           }else{

			//display total orders
			$countData = $countData + count($out);

			$tB = substr($out[0][1], 0, -3); 
			$tB = gmdate('d-m-Y H:i:s', $tB );

			$tE = substr($out[(count($out)-1)][1], 0, -3);
			$tE = gmdate('d-m-Y H:i:s', $tE );

			echo $countData.'  '.$tB.'  '. $tE."\r";

			$fp = fopen($fileName, 'a');   
			fwrite($fp, $csv); 
			fclose($fp);  


           }


		}else{


           if($_POST['do']=="api"){

           		$returnCsv .= $csv; 

           }else{

			$fp = fopen($fileName, 'a');   
			fwrite($fp, $csv); 
			fclose($fp);  
           }


           break; 



			
		}


	}else{

		break; 

	}


	sleep(2);

}


if($_POST['do']=="api"){

	echo $returnCsv;

}






	








?>