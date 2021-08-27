<?php 
//price wave
ini_set('memory_limit', '2000M');
$periodArr = array();
$startKey = 0;  $uniq = array();

$CASH = array();


// $arrA = explode("\n", file_get_contents('history/01-06-2019---15-06-2019---BTCUSD.csv'));

// $countArr = count($arrA);
// //get last row
// for($i=0; $i<=($countArr-1); $i++){

// 	if(strlen($arrA[$i])>5){

// 		$tempA = explode(",", $arrA[$i]); 
// 		$CASH[] = (string)round($tempA[2], -1);

// 	}
// }



// //print_r($CASH);












$test = array( 
				1000,    //1
			700,         //2
		600,             //3
	500,                 //4
		600,             //5
	 		700,         //6
				1000,    //7
			700,  
			    1000,
			700,

	); 

 $test = $CASH;

$ids = array(); 

foreach ($test as $key => $price) {

	if(!array_key_exists($price, $ids)){

		$ids[$price] = array(); //array (0, 1); 0 - state, 1 - count; 

	}


	//get prev price
	if($key>0){

		$t= $key-1; 
		$prevPrice = $test[$t];


		if($prevPrice>$price){

            //if($prevPrice!==$price){

				$ids[$price] = 0;
				$ids[$prevPrice]= 0;  

			//}

		}else{


			if(array_key_exists($price, $ids)){

				//if($ids[$price] ==0) {

					for($i=$t; $i>=0; $i--){

						if($test[$i]==$price) break;

						$uniq[] = $test[$i];

					}


					$uniq = array_unique($uniq);

					

                    
					foreach ($uniq as $k => $v) {

						if(array_key_exists($price, $periodArr)){
						
							$periodArr[$price][$v] += 1; 

						}else{

							$periodArr[$price][$v] = 1;

						}
						
					}

					$uniq = array();

				//}
			}


			$ids[$price] = 1;
			$ids[$prevPrice] = 1; 





		}


    }

	
}



 krsort($periodArr);
// //viewer
$view = ''; $totalRound = 0;
// foreach($periodArr as $k=>$v){

//        krsort($v);

// 	foreach ($v as $k2 => $v2) {

		

// 		if($v2 > 2) {

// 			$totalRound =$totalRound+$v2;

// 			// $perc =  ($k2*100)/$k;
// 			// $perc = 100 - $perc;
// 			if($perc>0.2) {
// 			$view .= $k.'-'.$k2.' '.$v2.'  ' .round($perc, 2)."\n"; 
// 		//}

// 		}
		
// 	} 


// }

// echo $view;
// echo $totalRound;



print_r($ids)."\n";

//print_r($periodArr['8600']);












?>