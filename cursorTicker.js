// cursor 

var crTradeList =[];
var crTradeListKey = "";
var crI         = 0; 
var tmpI        = 0;
var crZ         = 0;  
var crMax       = ptMax; 

var crH = document.getElementById('cursorH'); 
var crV = document.getElementById('cursorV');

var crD = document.getElementById('cursorData'); 
var crD2 = document.getElementById('cursorData2'); 
var bdMargin = 8; //default matgin

//var bdStyle = bd.currentStyle || window.getComputedStyle(bd);

var crPrtA = 0; 
var crPrtB = 0; 
var crPrtC = 0;


function addTradeList(p, v, t){

	//console.log(crI+'--'+tmpI+'--'+crMax)

	crTradeList[crI] = [p, v, t];

	//this code use only if canvases has border-right:1px!
	if(tmpI==crMax-1){

		crI ++;
		crTradeList[crI] = [p, v, t];
		tmpI = 0;
	}else{

      tmpI ++;

	}

	
	   crI ++; 

} 



window.onload = function(){

	document.body.onmousemove = function(event) {
     
        //lines position
        if(crZ==0){

	        crH.style.display = "block";
			crV.style.display = "block";
			crZ++;
        }
     
		crH.style.top = event.clientY;
		crV.style.left = event.clientX;

        //Data blocks position
		crD.style.top  = event.clientY - crD.clientHeight;
		crD.style.left = event.clientX + 5;

		crD2.style.top  = event.clientY - crD2.clientHeight-crD.clientHeight;
		crD2.style.left = event.clientX + 5;


        //Add data to Data block
	    if(event.pageX-bdMargin in crTradeList){

			crTradeListKey = event.pageX-bdMargin; 
			
			tradeList      = crTradeList[crTradeListKey];

	    	if(tradeList[0]>0){

	    		tradeListColor = 'green'; 

	    	}else{

				tradeListColor = '#cc0000'; 
	    	}



           tmstp = tradeList[2].toString(); 
	       tmstp = tmstp.substr(0, 10);
            //date 
			dt.setTime(tmstp*1000);
				h = dt.getUTCHours(); //+ dt.getTimezoneOffset()/60; 
				m = dt.getUTCMinutes(); 
				s = dt.getUTCSeconds();
				dy = dt.getUTCDate();
				mth = dt.getUTCMonth()+1;
				hms = h+':'+m+':'+s+'   '+dy+'-'+mth;

	        crD.innerHTML='<div class="cdPrice" style="color:'+tradeListColor+'">'+Math.round(tradeList[0]*10)/10+'</div>'

		        +'<div class="cdVol" style="color:'+tradeListColor+'">'+Math.round(tradeList[1]*10)/10+'</div>'
		        +'<div class="cdDate"style="color:#868686">'+hms+'</div>';
	        //  crD.innerHTML = crTradeList[event.pageY][0].replace(/&/g, '&amp;').replace(/</g, '&lt;');
	    }
    }



    //get percent from A & B selections
    //get vol from A to B selections
    document.body.onclick = function(event){


    	if(crPrtA ==0){

    		crKeyA = crTradeListKey; 

    		crPrtA = Math.abs(tradeList[0]);

    		crHTML = crPrtA; 

    		
    	}else{

    		crKeyB = crTradeListKey; 

    		crPrtB = Math.abs(tradeList[0]);

                //count % of price
				if(crPrtA>crPrtB){

					crPrtC = (crPrtA*100)/crPrtB - 100; 


				}

				if(crPrtB>crPrtA){

					crPrtC = (crPrtB*100)/crPrtA - 100; 

				}

				crPrtC = Math.round(crPrtC *100 ) / 100;



				//count vol, sum of ASK, BID
				sumVolASK = 0; sumPriceASK = 0;
				sumVolBID = 0; sumPriceBID = 0


				if(crKeyA>crKeyB){

					tempA = crKeyB; tempB = crKeyA;

					crKeyA = tempA; crKeyB = tempB;
				}
                


				for(i=crKeyA; i<=crKeyB; i++){

                    arr = crTradeList[i];

					if(arr[0]>0) {

						sumVolBID = sumVolBID + arr[1];
						sumVolBID = Math.round(sumVolBID*100000000) / 100000000;

						sumPriceBID = sumPriceBID + (arr[0]*arr[1]); 
						sumPriceBID = Math.round(sumPriceBID*10) / 10;

					}else{

						sumVolASK = sumVolASK + Math.abs(arr[1]);
                        sumVolASK = Math.round(sumVolASK*100000000) / 100000000;

	       			    sumPriceASK = sumPriceASK + Math.abs(arr[0]*arr[1]); 
						sumPriceASK = Math.round(sumPriceASK*10) / 10;
					}

				}
    
                console.log(sumVolBID+'--'+sumVolASK+'--'+sumPriceBID+'--'+sumPriceASK);




                //display
				crHTML = crPrtA+'&nbsp;|&nbsp;'+crPrtB+'&nbsp;&nbsp;'+crPrtC+'<br/>'

				 +sumVolBID+'&nbsp;|&nbsp;'+sumVolASK+'<br/>'

				 +sumPriceBID+'&nbsp;|&nbsp;'+sumPriceASK;



				setTimeout(function(){ crD2.innerHTML=""; }, 4000); 

				crPrtA = 0; crPrtB = 0; 
    		
    	}  


    	crD2.innerHTML = crHTML;        
             

    }

}

// end cursor