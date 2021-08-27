//Kiselevich Vyacheslav. 
//PriceTicker version 2.0 13.04.2018 
//param p -   0.0 $,  +int-BUY, -int-SELL

var ptSize      = 1;
var ptZoom      =  ptSize;
var sizeH =0;   var ptLastSizeH = 0; 

var ptH         = 30000;
var ptI         = 0;
var ptW;  
var ptMax       = 300;      //max Orders 


var ptLastPrice = 0; 
var ptLastY     = 0; var stableP = 0; var stableY =0;
var ptColorBuy  = 'green'; 
var ptColorSell = 'red';


var ptCanvasNum =0; // numeric canvas


var ptContainer = "ptContainer"; //id_element in which add Canvases; 
var ptCon       = document.getElementById(ptContainer);

var ptC; 
var ptCTX;

var ptFS; 

var curT = 0; 




//calculate weight of cavas
ptW     = ptSize * ptMax; 


var scrollCenter = 0; 


function ptAddCanvas(){


	id                 = 'ptCanvas'+ptCanvasNum++; 
	var ptCanvas       = document.createElement('canvas');
	ptCanvas.className = 'ptCanvas';
	ptCanvas.id        = id; 
	
	ptCon.appendChild(ptCanvas); 
	

	ptC                = document.getElementById(id); 
	ptCTX              = ptC.getContext("2d");
	ptC.width          = ptW;
	ptC.height         = ptH;
	
	//add num of canvas

	ptCTX.font         = "15px Arial";
	ptCTX.fillText(ptCanvasNum, 5, 15); 

    //set Y scroll to center of clientHeight
	if(scrollCenter==0){

		document.body.scrollTop = document.body.scrollHeight/2 - document.body.clientHeight/2;

		scrollCenter++; 
	}


}


dt = new Date();

function priceTicker(p, currentTicker = 0){


	if(currentTicker==0){

		//add new canvas & reset counter
	    if (ptI/ptMax ==0 || ptI/ptMax ==1 ) { ptI = 0; ptAddCanvas() }

	    //change color for Buy/Sell orders
		if(p > 0) { ptFS=ptColorBuy; }else{ ptFS=ptColorSell; }

		//		xv = 0;
		// 		if(bv>0) {xv = bv}
		//		if(sv<0) {xv = Math.abs(sv)}
		//  	if(xv>10) {ptCTX.globalAlpha = 0.8;}else{	ptCTX.globalAlpha = 0.2;}



		p = Math.abs(p); 

		if(ptLastPrice==0) {

			y = ptH/2;  

			stableP = p;

			stableY = y; 

			ptLastY = y; 

			ptLastPrice = p;

			ptCTX.fillRect(0, y, ptSize, 1);
	       
	    	
		}else {

	        x     = ptSize*ptI;


			sizeH       = ((p * 100) / stableP)-100;
			sizeH       = (Math.round(sizeH * 10)/10)*100;

	        if(sizeH>0){ y = stableY - sizeH;}else{ y = stableY - (sizeH);}

	        h = Math.abs(ptLastY - y);
	        if(h<1){h=1; y = ptLastY;}
	         

			   timestamp = timestamp.toString(); 
		       timestamp = timestamp.substr(0, 10);
	        	
			   dt.setTime(timestamp*1000);
	    	   dy = dt.getUTCDate();

	    	   if ( dy & 1 ){

					ptCTX.fillStyle = '#151212';
				    ptCTX.fillRect(x, 0, 1, ptH);
				   

	    	   }

	 			ptCTX.fillStyle = ptFS
		 

			if( p > ptLastPrice ) {	
		
				

			//	ptCTX.globalAlpha = 0.2;

			//	ptCTX.fillRect(x, y, 1,  h);

				if(h>20){

					ptCTX.globalAlpha = 0.4;

					ptCTX.fillRect(x, y, 1,  h);

				}





				ptCTX.globalAlpha = 1;

				ptCTX.fillRect(x, y, 1,  1);


				//console.log(x+'---'+y+'-----')



			}


			if( p < ptLastPrice ) {	

			//	ptCTX.globalAlpha = 0.2;

			//	ptCTX.fillRect(x, y, 1,  -h);

				if(h>20){

					ptCTX.globalAlpha = 0.4;

					ptCTX.fillRect(x, y, 1,  -h);

				}




				ptCTX.globalAlpha = 1;

				ptCTX.fillRect(x, y, 1,  1);

				//console.log(x+'---'+y+'-----')
			
			}


			if( p == ptLastPrice ) {	

				ptCTX.fillRect(x, y, 1,  1);

				//console.log(x+'---'+y+'-----')

				
			}

			ptLastY = y;
			ptLastPrice = p;

	    }

		ptI++; 

	}


	if(currentTicker==2){

		//cursorTicker

		//add new canvas & reset counter
	    //	if (ptI/ptMax ==0 || ptI/ptMax ==1) { ptI = 0; ptAddCanvas() }

		    //change color for Buy/Sell orders
			if(p > 0) { ptFS=ptColorBuy; }else{ ptFS=ptColorSell; }

			//ptFS = "#5885ef";

			//		xv = 0;
			// 		if(bv>0) {xv = bv}
			//		if(sv<0) {xv = Math.abs(sv)}
			//  	if(xv>10) {ptCTX.globalAlpha = 0.8;}else{	ptCTX.globalAlpha = 0.2;}



			p = Math.abs(p); 

			if(ptLastPrice==0) {

				ptAddCanvas();

				y = ptH/2;  

				stableP = p;

				stableY = y; 

				ptLastY = y; 

				ptLastPrice = p;

				ptCTX.fillRect(0, y, ptSize, 1);


				x = 1; ptI =1;


		    	
			}else {

				//x     = ptSize*ptI;
		        


				sizeH       = ((p * 100) / stableP)-100;
				sizeH       = (Math.round(sizeH * 10)/10)*100;

		        if(sizeH>0){ y = stableY - sizeH;}else{ y = stableY - (sizeH);}

		        h = Math.abs(ptLastY - y);
		        if(h<1){h=1; y = ptLastY;}
		         

				  //  timestamp = timestamp.toString(); 
			   //     timestamp = timestamp.substr(0, 10);
		        	
				  //  dt.setTime(timestamp*1000);
		    // 	   dy = dt.getUTCDate();

		    // 	   if ( dy & 1 ){

						// ptCTX.fillStyle = '#0a0909';
					 //    ptCTX.fillRect(x, 0, 1, ptH);
					   

		    // 	   }

		 		//	ptCTX.fillStyle = ptFS

		 		x = x+10;		 

				if( p > ptLastPrice ) {	
			
					ptCTX.globalAlpha = 0.1;

					ptCTX.fillRect(x, y, 2,  1);
					
				}


				if( p < ptLastPrice ) {	

					ptCTX.globalAlpha = 0.1;

					ptCTX.fillRect(x, y, 2,  1);

				}


				if( p == ptLastPrice ) {	

					ptCTX.globalAlpha = 0.1;


					ptCTX.fillRect(x, y, 2,  1);

				}

				x = x-10;

				//delet prev 

				//ptCTX.fillStyle ="#000";

				//ptCTX.fillRect(x, y, -5,  1);

				ptLastY = y;
				ptLastPrice = p;

		    }

			//ptI++; 


	}



	






}

	
