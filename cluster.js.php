<script type="text/javascript">


//display cluster analys ASK/BID

var clPerc = 120; // scale height
var startGraph = 0; 
var clCont = '#clusterContainer';

var clTimestamp = 0; 
var clPrevTimestamp =0;
var clTsI = 0; var clPrevOrder =0;  var clPOmax = 100// bid/ask
var clVolMin = 50;

var clTimePeriod = Number(period); //sec 
var clTime = 0;  
var clI = 0;
var clArrPV = [];



var prevPid = 0; var prevTid =0;


var volLineMax = 100000000;
//agrigate view
//1, ex: 1001, 1002
//5, ex: 1005, 1010
//10, ex: 1010, 1020
//20, ex: 1020, 1040
//25, ex: 1025, 1050
//100, ex: 1100, 1200

var agrigate = ag;


//sum   = vol * price

var sumA = 0; var sumB = 0; 





function clAddCol(){

  clI++; 

  tmstp = clTimestamp.toString(); 
  tmstp = tmstp.substr(0, 10);
  //date 
  dt.setTime(tmstp*1000);
  h = dt.getUTCHours(); //+ dt.getTimezoneOffset()/60; 
  m = dt.getUTCMinutes(); 
  s = dt.getUTCSeconds();
  dy = dt.getUTCDate();
  mth = dt.getUTCMonth()+1;
  hms = dy+'-'+mth;



	html  ='<div class="clusterCol clTimeVol">';

	html +='<div>'+hms+'</div>';

	// for(i=clUpY; i>=clDownY; i--){

    
	// //id example cl_1_1500b, cl_1_1500a,
	// bidId =  'cl_'+clI+'_'+i+'b';
	// askId =  'cl_'+clI+'_'+i+'a';
	// html +='<div><div id="'+bidId+'" class="clb"></div><div id="'+askId+'" class="cla"></div></div>';

	// }

  whY = clUpY


  while(whY>clDownY){
    
    whY = whY - agrigate;


    if(agrigate<10){

      whY = Math.round(whY*10)/10;

    }


     whY_conv = whY.toString();

     whY_conv = whY_conv.replace(".", "_");






  //id example cl_1_1500b, cl_1_1500a,
  bidId =  'cl_'+clI+'_'+whY_conv+'b';
  askId =  'cl_'+clI+'_'+whY_conv+'a';
  html +='<div><div id="'+bidId+'" class="clb"></div><div id="'+askId+'" class="cla"></div></div>';

  }

	html +='<div>---</div>';

	html+='</div>';

	$(clCont).append(html);

	


}










function cluster(){

    clTimestamp = timestamp.toString();
    clTimestamp =  clTimestamp.substr(0, 10);      
    

	//first column (scale of prices)
	if(startGraph==0){

    price = parseInt(price)

		clCenterY  = price;
		clUpY      = price + ((price/100)*clPerc);
		clDownY    = price - ((price/100)*clPerc);

    
    clCenterY  = Math.abs(Math.round(clCenterY /agrigate)*agrigate);
    clUpY      = Math.abs(Math.round(clUpY     /agrigate)*agrigate);
    clDownY    = Math.abs(Math.round(clDownY   /agrigate)*agrigate);



        html  ='<div class="clusterCol clScale">';

	        html +='<div>P,T,V</div>';



        whY = clUpY; 



        while(whY>clDownY) {

          whY = whY - agrigate; 

          if(agrigate<10){

              whY = Math.round(whY*10)/10;




          }else{

              whY_conv = whY;
          }

          whY_conv = whY.toString();

          whY_conv = whY_conv.replace(".", "_");






          html +='<div>'

                  +'<div>'+whY+'</div>'

                  +'<div id="sum_'+whY_conv+'b" class="clb"></div>'
                  +'<div id="sum_'+whY_conv+'a" class="cla"></div>'

                  +'<div id="ttv_'+whY_conv+'b" class="clb"></div>'
                  +'<div id="ttv_'+whY_conv+'a" class="cla"></div>'

                  +'<div class="volLineBox">'
                  +'<div id="vol_'+whY_conv+'b" class="vlb"></div>'
                  +'<div id="vol_'+whY_conv+'a" class="vla"></div>'
                  +'</div>'
               +'</div>';


        }



			html +='<div>P,T,V</div>';

		html+='</div>';

           
			$(clCont).prepend(html);

			startGraph = 1;

			html="";
     
	}



	if(clTimestamp>=clTime || clTime==0) {

	   clTime = Number(clTimestamp) + clTimePeriod;


     if(clTimePeriod>0){

         clAddCol();

     }

	   
	}
 	   
      

 	    //priceId =  Math.round(Math.abs(price) *1)/1;

      price = Number(price);

    if(agrigate<10){

      priceId =  Math.round(Math.abs(price) *10) / 10;

      
      
    }else{

      priceId =  Math.round(Math.abs(price) /agrigate)*agrigate;

    }


    priceId = priceId.toString();

    priceId = priceId.replace(".", "_");
      

    	clVol   =  Math.abs(vol);


        if(vol>0){

            //add to HTML vol bid 
           pid = $('#cl_'+clI+'_'+priceId+'b');

        
           
          //detect fast orders 
          if(clPrevTimestamp==clTimestamp & clPrevOrder=="bid"){
           
             clTsI++; 

            // if(clTsI>clPOmax) { pid.css('font-weight', 'bold'); }

          }else{

             clTsI = 0; 

          }



           lastVol = pid.html();
           newVol =  Math.round( (Number(lastVol)+Number(clVol)) *10)/10 ;
           if(newVol<10){
                
                pid.css('color', '#47600b');
                pid.html(newVol);

           }else{

                 newVol =  Math.round( newVol *1)/1 ;
                
                 pid.css('color', '');
                 pid.html(newVol);

                 if(Number(clVol)>clVolMin){                 

             //     pid.css({"border-color":"#7faa16"});
                  
                 }

           }





           id="ttv_'+whY+'b"


       	   //add to HTML total vol bid
       	   tid = $('#ttv_'+priceId+'b');
       	   lastTotalVol = tid.html();
       	   if(typeof lastTotalVol == "undefined") {lastTotalVol=0}
            
       	   tid.html( Math.round( (Number(lastTotalVol)+Number(clVol))*1)/1);


           //add to HTML total sum bid
           sid = $('#sum_'+priceId+'b');
           lastSum = sid.html();
           if(typeof lastSum == "undefined") {lastSum=0}


            prId = priceId.replace("_", ".");

           ls = Math.round( ( Number(lastSum)+Number(clVol*prId) ) *1)/1;
           sid.html(ls);


          //add to HTML line bid
          vid = Math.round( ((ls * 100) / volLineMax) *1)/1; 
          $('#vol_'+priceId+'b').css('width', vid+'%');







           if(prevPid==0){ 

	        
 	        	tid.css('background-color', '#61f72c');
 	        	pid.css('background-color', '#61f72c'); 
  

            prevTid = '#ttv_'+priceId+'b'; 
 	        	prevPid = '#cl_'+clI+'_'+priceId+'b';

           }else {
 
                 $(prevTid).css('background-color', '');
                 $(prevPid).css('background-color', '');
          

                 tid.css('background-color', '#61f72c');
                 pid.css('background-color', '#61f72c');
     

                 prevTid = '#ttv_'+priceId+'b'; 
 	        	 prevPid = '#cl_'+clI+'_'+priceId+'b';


           }


          


       	  
           clPrevOrder = 'bid';


           if(newVol==""){

               pid.css('background-color', '#1d7534')

           }else{

                pid.css('background-color', '')
           }



           if(priceId == "356_2"){

            console.log(newVol+"---")
           }
         

        }else{

     //    	//add to array "1" - ask
     //    	if(priceId in clArrPV){

     //    		if( clArrPV[priceId][1].length<1){

     //    			clArrPV[priceId][1] = clVol; 

     //    		}else{

					// clArrPV[priceId][1]  += clVol; 
     //    		}

     //    	}else{

					// clArrPV[priceId]  = ['', clVol]; 

     //    	}

           // //add vol bid ask
           pid = $('#cl_'+clI+'_'+priceId+'a'); 
          //detect fast orders 
          if(clPrevTimestamp==clTimestamp & clPrevOrder=="ask"){
           
             clTsI++; 

             if(clTsI>clPOmax) { pid.css('font-weight', 'bold'); }

          }else{

             clTsI = 0; 

          }



           lastVol = pid.html();
           newVol =  Math.round( (Number(lastVol)+Number(clVol)) *10)/10 ;
           if(newVol<10){
                
                pid.css('color', '#8c3232');
                pid.html(newVol);

           }else{

                 newVol =  Math.round( newVol *1)/1 ;

                 pid.css('color', '');
                 pid.html(newVol);

                 if(Number(clVol)>clVolMin){                 

                //  pid.css({"border-color":"#e75656"});
                  
                 }
           }

           //add total vol ask
       	   tid = $('#ttv_'+priceId+'a');
       	   lastTotalVol = tid.html();
       	   if(typeof lastTotalVol == "undefined") {lastTotalVol=0}
       	   tid.html( Math.round( (Number(lastTotalVol)+Number(clVol))*1)/1);


           //add to HTML total sum ask
           sid = $('#sum_'+priceId+'a');
           lastSum = sid.html();
           if(typeof lastSum == "undefined") {lastSum=0}

             prId = priceId.replace("_", ".");
          ls =  Math.round( ( Number(lastSum)+Number(clVol*prId) ) *1)/1;
           sid.html(ls);



          //add to HTML line ask
          vid = Math.round( ((ls * 100) / volLineMax) *1)/1; 
          $('#vol_'+priceId+'a').css('width', vid+'%');




           if(prevPid==0){ 

	        
 	        	tid.css('background-color', '#f30000');
 	        	pid.css('background-color', '#f30000');
            

                prevTid = '#ttv_'+priceId+'a'; 
 	        	prevPid = '#cl_'+clI+'_'+priceId+'a';

           }else {
 
                 $(prevTid).css('background-color', '');

                 $(prevPid).css('background-color', '');
               

                 tid.css('background-color', '#f30000');
                 pid.css('background-color', '#f30000');
               
               

                 prevTid = '#ttv_'+priceId+'a'; 
 	        	 prevPid = '#cl_'+clI+'_'+priceId+'a';

           }

            clPrevOrder = 'ask';
        }
   
        

        //add color 

        if(ls<=5000000){  sid.css('background-color', '#032978');}
        if(ls>5000000 & ls<=10000000){  sid.css('background-color', '#750378');}
        if(ls>10000000 & ls<=15000000){  sid.css('background-color', '#780330');}
        if(ls>15000000 & ls<=20000000){  sid.css('background-color', '#780303');}
        if(ls>20000000 & ls<=25000000){  sid.css('background-color', '#a60202');}
        if(ls>30000000){  sid.css('background-color', '#fffb14');}

         clPrevTimestamp = clTimestamp; 

}

</script>




