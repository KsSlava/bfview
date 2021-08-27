<?php 
//price wave
ini_set('memory_limit', '2000M');
$periodArr = array();
$startKey = 0;  $uniq = array();

$CASH = array();


$arrA = explode("\n", file_get_contents('07-10-2020---10-10-2020---BTCUSD.csv'));

 $countArr = count($arrA);

$tmsp = []; 

$tm =[];


$output = [];

// //get last row

$prevInt = 0; 
for($i=0; $i<=($countArr-1); $i++){

	if(strlen($arrA[$i])>5){

		$ar = explode(",", $arrA[$i]); 

		

		//$int = round($ar[2], 1);
		$ai = explode(".", $ar[2]);

		$int = $ai[0];

		settype($int, "string");
		
      // if($i==1) break;

		if($int!==$prevInt){

			$tmsp[]  = $ar[0]; 

			$CASH[] = $int; 

			$prevInt = $int;

		}
	}


	//if($i==2000) break;
}






 $d1  =  $countArr . '--'.count($CASH);


//print_r($CASH);


// $test = array( 
// 				1000,    //1
// 			700,         //2
// 		600,             //3
// 	500,                 //4
// 		600,             //5
// 	 		700,         //6
// 				1000,    //7
// 			700,  
// 			    1000,
// 			700,

// 	); 

$test = $CASH;

foreach ($test as $key => $price) {
 

	// //get prev price
	if($key>0){

		$t= $key-1; 
		$prevPrice = $test[$t];

		if($prevPrice<$price){
                   
			for($i=$t; $i>=0; $i--){

				   $xxx = ($price *100) / $test[$i]; 
                   $xxx = $xxx - 100; 

				$uniq["begin"] = $test[$i];
 
				if($test[$i]>=$price) break;


                    


                //   if($xxx>=0.3 and $xxx <=0.5 ){
				   $uniq[$i] = $test[$i];
				//  }

			}

			if(count($uniq)>1) {

				$uniq = array_unique($uniq);

				array_shift($uniq);

				foreach ($uniq as $k => $v) {

					if(array_key_exists($price, $periodArr)){
					
						$periodArr[$price][$v] += 1; 

					}else{

						$periodArr[$price][$v] = 1;

					}

				//display
						$view = ''; $totalRound = 0; krsort($periodArr);
						foreach($periodArr as $k=>$v){

						    krsort($v);

							foreach ($v as $k2 => $v2) {


								

									//$totalRound =$totalRound+$v2;

									//$perc =  ($k2*100)/$k;
									//$perc = 100 - $perc;
									//if($v2>2) {
										$view .= $k.'-'.$k2.' '.$v2."\n"; 
									//}



									  if(array_key_exists($k, $output)){


									  	 if($k2<$output[$k]){


									  	 	$output[$k] = [$k2, $v2]; 
									  	 }


									  }else{


											$output[$k] = [$k2, $v2]; 


									  }













								
								
							} 

						}
 						popen('cls', 'w');
						echo $view."\r";

					//	$view ="";

			
				}			
			
              
			}
		

            


			 $uniq = array();
          
				
		}

    }

	//usleep(100);


	echo $d1.'/'.$key."\r";

	
}


 print_r($output);


krsort($output);


foreach ($output as $key => $value) {


				   $xxx = ($value[0] *100) / $key; 
                   $xxx = $xxx - 100; 
	

	echo $key."---".$value[0]."---".round($xxx, 2)."%---".$value[1]."\n";


}













// //viewer
// $view = ''; $totalRound = 0; krsort($periodArr);
// foreach($periodArr as $k=>$v){

//     krsort($v);

// 	foreach ($v as $k2 => $v2) {


		

// 			//$totalRound =$totalRound+$v2;

// 			//$perc =  ($k2*100)/$k;
// 			//$perc = 100 - $perc;
// 			if($v2>4) {
// 				$view .= $k.'-'.$k2.' '.$v2."\n"; 
// 			}

		
		
// 	} 

// }




 //print_r($periodArr);
?>