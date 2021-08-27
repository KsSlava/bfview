/*terminal v4 - analysis HFT trade book. Return count: orders, vol, sum  for 3 periods of day (00:00 - 08:00, 08:00 - 16:00, 16:00 - 23:59)
  by Kiselevich Slava 15-08-2019, infomixks@gmail.com
*/



var prevDay    = 0; var toDay; 
//orders
var ordTot     =0;  var ordTotB=0; var ordTotА=0;
var ordTotA_p1 =0;  var ordTotA_p2=0; var ordTotA_p3=0; 
var ordTotB_p1 =0;  var ordTotB_p2=0; var ordTotB_p3=0;

//vol
var ordVol     =0;  var ordVolB=0; var ordVolА=0;
var ordVolA_p1 =0;  var ordVolA_p2=0; var ordVolA_p3=0; 
var ordVolB_p1 =0;  var ordVolB_p2=0; var ordVolB_p3=0;

//sum
var ordSum     =0;  var ordSumB=0; var ordSumА=0;
var ordSumA_p1 =0;  var ordSumA_p2=0; var ordSumA_p3=0; 
var ordSumB_p1 =0;  var ordSumB_p2=0; var ordSumB_p3=0;

 sC = $('#v4Container'); var html;



 function reset(){

		ordTot     =0;   ordTotB =0;  ordTotА=0;
		ordTotA_p1 =0;   ordTotA_p2=0;  ordTotA_p3=0; 
		ordTotB_p1 =0;   ordTotB_p2=0;  ordTotB_p3=0;
		
		ordVol     =0;   ordVolB=0;  ordVolА=0;
		ordVolA_p1 =0;   ordVolA_p2=0;  ordVolA_p3=0; 
		ordVolB_p1 =0;   ordVolB_p2=0;  ordVolB_p3=0;
		
		ordSum     =0;   ordSumB=0;  ordSumА=0;
		ordSumA_p1 =0;   ordSumA_p2=0;  ordSumA_p3=0; 
		ordSumB_p1 =0;   ordSumB_p2=0;  ordSumB_p3=0;
 }


function getPerc(b, s){

	if(b<s){

		x = (s * 100 ) / b - 100;
		x = Math.round(x*10)/10; 

		html = '<span style="color:#fb0c00;">'+x+'</span>';

	}else{

		x = (b * 100 ) / s - 100; 
		x = Math.round(x*10)/10;


		html = '<span style="color:#4eba13;">'+x+'</span>';

	}

	

	return html; 
}



function display(){




		ordTot=Math.round(ordTot);  ordTotB=Math.round(ordTotB); ordTotА=Math.round(ordTotА);
		ordTotB_p1=Math.round(ordTotB_p1); ordTotA_p1=Math.round(ordTotA_p1);
		ordTotB_p2=Math.round(ordTotB_p2); ordTotA_p2=Math.round(ordTotA_p2);
		ordTotB_p3=Math.round(ordTotB_p3); ordTotA_p3=Math.round(ordTotA_p3);

		ordVol=Math.round(ordVol*10)/10;  ordVolB=Math.round(ordVolB*10)/10; ordVolА=Math.round(ordVolА*10)/10;
		ordVolB_p1=Math.round(ordVolB_p1*10)/10; ordVolA_p1=Math.round(ordVolA_p1*10)/10;
		ordVolB_p2=Math.round(ordVolB_p2*10)/10; ordVolA_p2=Math.round(ordVolA_p2*10)/10;
		ordVolB_p3=Math.round(ordVolB_p3*10)/10; ordVolA_p3=Math.round(ordVolA_p3*10)/10;


		ordSum=Math.round(ordSum);  ordSumB=Math.round(ordSumB); ordSumА=Math.round(ordSumА);
		ordSumB_p1=Math.round(ordSumB_p1); ordSumA_p1=Math.round(ordSumA_p1);
		ordSumB_p2=Math.round(ordSumB_p2); ordSumA_p2=Math.round(ordSumA_p2);
		ordSumB_p3=Math.round(ordSumB_p3); ordSumA_p3=Math.round(ordSumA_p3);

		// ordVol=Math.round( );  ordVolB=Math.round( ); ordVolА=Math.round( );
		// ordVolB_p1=Math.round( ); ordVolA_p1=Math.round( );
		// ordVolB_p2=Math.round( ); ordVolA_p2=Math.round( );
		// ordVolB_p3=Math.round( ); ordVolA_p3=Math.round( );

		// ordSum=Math.round( );  ordSumB=Math.round( ); ordSumА=Math.round( );
		// ordSumB_p1=Math.round( ); ordSumA_p1=Math.round( );
		// ordSumB_p2=Math.round( ); ordSumA_p2=Math.round( );
		// ordSumB_p3=Math.round( ); ordSumA_p3=Math.round( );



		html = '<span class="prevDay">'+prevDay+'</span>'+
		       '<span class="ordTot">'+ordTot+'</span> <span>:</span>'+
		       '<span class="ordTotB">'+ordTotB+'</span> <span class="ordTotА">'+ordTotА+'</span>'+

		'<span class="ordTotB_p1">'+ordTotB_p1+'</span> <span class="ordTotA_p1">'+ordTotA_p1+'</span>'+
		'<span class="ordTotB_p2">'+ordTotB_p2+'</span> <span class="ordTotA_p2">'+ordTotA_p2+'</span>'+
		'<span class="ordTotB_p3">'+ordTotB_p3+'</span> <span class="ordTotA_p3">'+ordTotA_p3+'</span>'+

		'<span class="ordVol">'+ordVol+'</span> <span>:</span>'+
		'<span class="ordVolB">'+ordVolB+'</span> <span class="ordVolА">'+ordVolА+'</span>' +
		'<span class="perc">'+getPerc(ordVolB, ordVolА)+'</span>' +



		'<span class="ordVolB_p1">'+ordVolB_p1+'</span> <span class="ordVolA_p1">'+ordVolA_p1+'</span>'+
        '<span class="perc">'+getPerc(ordVolB_p1, ordVolA_p1)+'</span>' +

        '<span class="ordVolB_p2">'+ordVolB_p2+'</span> <span class="ordVolA_p2">'+ordVolA_p2+'</span>'+
        '<span class="perc">'+getPerc(ordVolB_p2, ordVolA_p2)+'</span>' +

		'<span class="ordVolB_p3">'+ordVolB_p3+'</span> <span class="ordVolA_p3">'+ordVolA_p3+'</span>'+
		'<span class="perc">'+getPerc(ordVolB_p3, ordVolA_p3)+'</span>' +

		'<span class="ordSum">'+ordSum+'</span> <span>:</span> '+
		'<span class="ordSumB">'+ordSumB+'</span> <span class="ordSumА">'+ordSumА+'</span>' +
		'<span class="perc">'+getPerc(ordVolB_p3, ordVolA_p3)+'</span>' +

		'<span class="ordSumB_p1">'+ordSumB_p1+'</span> <span class="ordSumA_p1">'+ordSumA_p1+'</span>'+
		'<span class="perc">'+getPerc(ordSumB_p1, ordSumA_p1)+'</span>' +

		'<span class="ordSumB_p2">'+ordSumB_p2+'</span> <span class="ordSumA_p2">'+ordSumA_p2+'</span>'+
		'<span class="perc">'+getPerc(ordSumB_p2, ordSumA_p2)+'</span>' +

		'<span class="ordSumB_p3">'+ordSumB_p3+'</span> <span class="ordSumA_p3">'+ordSumA_p3+'</span>'+
		'<span class="perc">'+getPerc(ordSumB_p3, ordSumA_p3)+'</span>' ;




}


















function terminalV4(){

			

if(typeof tOrder !== "undefined"){

	prc  = Math.abs(price);
	vl   = Math.abs(vol);


	type = tOrder;
	timestamp = timestamp.toString(); 
	timestamp = timestamp.substr(0, 10);
	dt.setTime(timestamp*1000);
		h         = dt.getUTCHours(); 
		m         = dt.getUTCMinutes(); 
		s         = dt.getUTCSeconds();
		dy        = dt.getUTCDate();
		mth       = dt.getUTCMonth()+1;
		yr        = dt.getUTCFullYear();

		hms       = h+':'+m+':'+s+'   '+dy+'-'+mth;


		toDay = dy+'-'+mth+'-'+yr; 

      

		ordTot++; 

		ordVol = ordVol + vl;

		ordSum = ordSum +  (vl* prc);






		if(type=="buy"){

			ordTotB++; 	
			ordVolB = ordVolB + vl;
			ordSumB = ordSumB +  (vl* prc);

			//00:00 - 08:00
			if(h<8){ ordTotB_p1++; ordVolB_p1 = ordVolB_p1 + vl; ordSumB_p1 = ordSumB_p1 + (vl*prc); } 
			//08:00 - 16:00
			if(h>=8 & h<16){ ordTotB_p2++; ordVolB_p2 = ordVolB_p2 + vl; ordSumB_p2 = ordSumB_p2 + (vl*prc); } 
			//16:00 - 23:59
			if(h>=16 & h<=23){ ordTotB_p3++; ordVolB_p3 = ordVolB_p3 + vl; ordSumB_p3 = ordSumB_p3 + (vl*prc); } 

		}else{

			ordTotА++; 	
			ordVolА = ordVolА + vl;
			ordSumА = ordSumА +  (vl* prc);

			//00:00 - 08:00
			if(h<8){ ordTotA_p1++; ordVolA_p1 = ordVolA_p1 + vl; ordSumA_p1 = ordSumA_p1 + (vl*prc); } 
			//08:00 - 16:00
			if(h>=8 & h<16){ ordTotA_p2++; ordVolA_p2 = ordVolA_p2 + vl; ordSumA_p2 = ordSumA_p2 + (vl*prc); } 
			//16:00 - 23:59
			if(h>=16 & h<=23){ ordTotA_p3++; ordVolA_p3 = ordVolA_p3 + vl; ordSumA_p3 = ordSumA_p3 + (vl*prc); } 

		}




		if(prevDay==0){	

			sC.append('<div id="'+toDay+'"></div>');

		}else{

     		if(prevDay!==toDay){

     			display();

			    $('#'+prevDay).html(html);

			      reset();

			        sC.append('<div id="'+toDay+'"></div>');
     		}else{

 				if(translationState == 0){ 

					display();

					$('#'+prevDay).html(html); 

				} 

     		}



     		// //if(translationState==0){ console.log(prevDay+'--'+toDay+'--'+translationState) }
     		//  if(prevDay!==toDay && translationState == 0){

			    //  sC.append('<div id="'+toDay+'"></div>');

     		//  }else{



     		//  }
		} 




			

		









	



	prevDay = toDay;

}


}


