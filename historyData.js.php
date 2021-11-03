<script type="text/javascript">

/*
 *get the history data 
 *use csv files or api request
 *from bitfinex
 */

var csv = [];
var csvI = 0; 
var phMax = 3000; var phMaxI = 0; var resetID = 0; 







function readFile(file)
{
    
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", file, false);
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                var allText = rawFile.responseText;

                 t = Papa.parse(allText);
                 csv = t.data.reverse();
                 csv = csv.reverse();

                 readData = 1; 
			       
              
            }
        }


    }

   rawFile.send(null);

}



function readAPI(symbol){


	if(tStart.length!=10 && tEnd.length!=10){

		tDate = new Date();

		tM = (tDate.getMonth()+1).toString(); 

		if(tM.length<2) {tM = '0'+tM;}

		tStart = tDate.getDate()+'-'+tM+'-'+tDate.getFullYear();


			tDate.setDate(tDate.getDate()+1); 

			tM = (tDate.getMonth()+1).toString(); 



          
			if(tM.length<2) {tM = '0'+tM; }

			tEnd = tDate.getDate()+'-'+tM+'-'+tDate.getFullYear();


	}




	$.ajax({

		url:'getOrders.php',
		method:'POST',
		async: false,
		data: {do:'api', symbol:symbol, start:tStart, end:tEnd},
		dataType:'text',
		error: function(){

			console.log('error');
		},
		success: function(e){

			     t = Papa.parse(e);
                 csv = t.data.reverse();
                 csv = csv.reverse();
			     
		}
			
			

	});



}







function playHist(){

	if(csv.length>0){

		translationState = 1; 


		for(i=0; i<=phMax; i++){

				id        = csv[csvI][1];
				timestamp = csv[csvI][0];
				vol       = Math.round(csv[csvI][3] *100000000) /100000000; 
				price     = csv[csvI][2];
				tOrder    = csv[csvI][4];




				if(tOrder=="sell") { 

					price = 0 - price;
					vol   = 0 - vol

					

				}else{

					price = price;
					vol   = vol

					

				}


	                                        
	                 
					if(terminal.length>=1){

						if(terminal==0) {

							priceTicker(price);
							volTicker(vol);
							addTradeList(price, vol, timestamp);
							helperTrade();

						}


						if(terminal==1){

							cluster();

						}



						if(terminal==3){

						   terminalV3();
	                   
						}



						if(terminal==4){

						terminalV4(); 

						}

					}else{

						//set default terminal 
						priceTicker(price);
						volTicker(vol);
						addTradeList(price, vol, timestamp);
						helperTrade();


					}



	                if(csvI==csv.length-1){

	                	translationState = 0;

		                scrH  = $('#t3_left')[0].scrollHeight; 
			            $('#t3_left').scrollTop(scrH);

			           

	                	break;

	                }else{


		               	csvI++;                 
		               
	                }


         



			if(i==phMax) {


				//console.log(i); 



				(function(n) {
				        setTimeout(function(){
				            playHist()
				        }, 10);
				    }(i));



			}
		}

	}

}



$(document).ready(function(){
 
   
	if(exchange==0) {

		if(csvFileName.length>1){


		    readFile("../bfcsv/"+csvFileName);

		}else{

			readAPI(symbol); 
		}


	}


	playHist();


})

</script>



