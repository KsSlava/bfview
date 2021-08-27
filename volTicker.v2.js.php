   <script type="text/javascript">

		//Kiselevich Vyacheslav. 
		//PriceTicker version 2.0 13.04.2018 
		//param p -   0.0 $,  +int-BUY, -int-SELL
		var vSize = ptSize;
		var vH    = 300;
		var vW; 
		var vY    = vH/2;
		var vX    =0;		 
		var vMax  = ptMax;      //max Orders in canvas

		var vColorBuy  = 'green'; 
		var vColorSell = 'red';


		var vCanvasNum = 0; // numeric canvas
		var vI         = 0;


		var vContainer = "vContainer"; //id_element in which add Canvases; 
		var vCon       = document.getElementById(vContainer);

        var vC; 
        var vCTX;

        //calculate weight of cavas
		vW     = vSize * vMax; 


		var prvM = 0; var prvH=0;
       
         
         dt = new Date();
        function vAddCanvas(){

            
	       timestamp = timestamp.toString(); 
	       timestamp = timestamp.substr(0, 10);



        	
			dt.setTime(timestamp*1000);
				h = dt.getUTCHours(); //+ dt.getTimezoneOffset()/60; 
				m = dt.getUTCMinutes(); 
				s = dt.getUTCSeconds();
				dy = dt.getUTCDate();
				mth = dt.getUTCMonth()+1;
				hms = h+':'+m+':'+s+'   '+dy+'-'+mth;
				

       	  	    
			id                = 'vCanvas'+vCanvasNum++; 
			var vCanvas       = document.createElement('canvas');
			vCanvas.className = 'vCanvas';
			vCanvas.id        = id; 
			
			vCon.appendChild(vCanvas); 
			
	
			vC                = document.getElementById(id); 
			vCTX              = vC.getContext("2d");
			vC.width          = vW;
			vC.height         = vH;
			

			//add num of canvas
			vCTX.font         = "12px Arial";
			vCTX.fillStyle    = "#868686";
			vCTX.fillText(vCanvasNum, 5, 270); 

			vCTX.font         = "10px Arial";
			vCTX.fillText(hms, 5, 290); 
  

        }



		function volTicker(v){

   		    //add new canvas & reset counter
            if (vI/vMax ==0 || vI/vMax ==1  ) { vI = 0; vX=0; vAddCanvas() }

            //change color for Buy/Sell orders
     		if(v > 0) { 

     			vCTX.fillStyle=vColorBuy;

     			v0 =''; 

     		}else{ 

     			vCTX.fillStyle=vColorSell;
     			v0 = '-';
                

     		}



     		if(Math.abs(v) <=0.00099999) {

     			vCTX.globalAlpha = 0.2; 

     			v = v0+'1';

     		}else{

	     		if(Math.abs(v) <=0.00999999) {

	     			vCTX.globalAlpha = 0.2; 

	     			v = v0+'2';

	     		}else{

	     			if(Math.abs(v)<=0.09999999){

	     				vCTX.globalAlpha =0.5;

	     				v = v0+'3'; 

	     			}else{

							if(Math.abs(v) <5) {

								vCTX.globalAlpha = 0.5; 

								v = parseInt(Math.abs(v)) +3 ; 
								v = v0 + v;

							}else{


								vCTX.globalAlpha = 0.8; 
								//v = parseInt(Math.abs(v)) +9 ; 
								v = parseInt(Math.abs(v)); 
								 v = (v * 100) / mv;

								

								  v = Math.round(v *10)/10;
								   v = v0 + v;
							}
	     			}


	     		}


     		}


     		//hours section 

     		








            

            //canvas 		
			if(vI==0) {



                vCTX.fillRect(0, vY, vSize, -v);
 
			}else{

                 
				vX = vSize*vI;

				
				vCTX.fillRect(vX, vY, vSize, -v);

				//----------------
				timestamp = timestamp.toString(); 
				timestamp = timestamp.substr(0, 10);
				dt.setTime(timestamp*1000);
				h         = dt.getUTCHours(); //+ dt.getTimezoneOffset()/60; 
				m         = dt.getUTCMinutes(); 
				s         = dt.getUTCSeconds();

				if(prvM!==m){
					hCTX = vCTX;
					//hCTX.fillStyle    = "#f9e724";
					hCTX.globalAlpha = 0.4;
					hCTX.fillRect(vX, 90, 1, 5);					
				}else{

					hCTX = vCTX;

					hCTX.fillStyle    = "#247ef9";
					hCTX.globalAlpha = 0.4;
					hCTX.fillRect(vX, 80, 1, 1);	

				}


				if(prvH!==h){
					hCTX = vCTX;
					hCTX.fillStyle    = "#f9e724";
					hCTX.fillRect(vX, 100, 1, 5);					
				}

				prvM = m; 
				prvH = h;

				//----------------

			}
           
	      
	            
             

			 vI++; 
	
		}



			//bottom auto  fixer  
		window.onscroll = function(event) {

			var vtScroll = document.body.scrollTop;
		   
			
			if(vtScroll>=1) {
	           
	            vBottomY = parseInt("-"+vtScroll); 
	         
	            document.getElementById(vContainer).style.bottom = vBottomY;

			}else{

				vBottomY = 0;

			    document.getElementById(vContainer).style.bottom = vBottomY;
			}

		}    


</script>