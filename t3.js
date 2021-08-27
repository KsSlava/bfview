/*terminal v3 - analysis HFT orders, which filled in 1 second.
  by Kiselevich Slava 11-03-2019, infomixks@gmail.com
   */


var v3_out = []; 
var prevTsp = 0;  var prevP = 0;
var buyColor = "#258c22"; var sellColor ="#c42a1a";
var bp; var bv; var bc; var bperc; var sp; var sv; var sc; var sperc; 


var dsI=0;
var tBvol = 0; var tSvol = 0;
var tBc = 0; var tSc = 0;
//display by limit vol, perc%

//var limVol = 5; 
var limPerc = 0;
var limC = 0;

function terminalV3(){
			tsp  = timestamp;
			prc  = Math.abs(price);
			vl   = Math.abs(vol);
			type = tOrder;



			//sort & calculate data of orders
			if(tsp in v3_out){

				if(type in v3_out[tsp]){

					v3_p =v3_out[tsp][type]['p']; 
					v3_v =v3_out[tsp][type]['v'];


					//perc % of change prc
					if(v3_p<prc){
						perc = (v3_p*100)/prc; perc = 100-perc;
					}else{
						perc = (prc*100)/v3_p; 
						perc = 100-perc;
					}

					v3_out[tsp][type]['v'] = Math.round( (v3_v + vl) *100000000) /100000000; 
		     		v3_out[tsp][type]['c'] +=1;
					v3_out[tsp][type]['perc'] =Math.round(perc*100)/100;

					//console.log(type);

				}else{
				
		
					v3_out[tsp][type]         = [];
					
					v3_out[tsp][type]['p']    = prc;
					v3_out[tsp][type]['v']    = vl;
					v3_out[tsp][type]['c']    = 1;
					v3_out[tsp][type]['perc'] = 0;

				}
			}else{
					v3_out[tsp]               = []; 
					v3_out[tsp][type]         = [];
					
					v3_out[tsp][type]['p']    = prc;
					v3_out[tsp][type]['v']    = vl;
					v3_out[tsp][type]['c']    = 1;
					v3_out[tsp][type]['perc'] = 0;

			}


			//display data of orders
			if(prevTsp < tsp & prevTsp>0){

				//console.log(v3_out[prevTsp])

				//buy 
				if("buy" in v3_out[prevTsp]){


					if(v3_out[prevTsp]['buy']['v'] >= limVol){ 

						bp    = v3_out[prevTsp]['buy']['p']; 
						bv    = v3_out[prevTsp]['buy']['v'];
						bc    = v3_out[prevTsp]['buy']['c'];
						//	bperc = v3_out[prevTsp]['buy']['perc'];


						priceTicker(bp);
						volTicker(bv);
						addTradeList(bp, bv, prevTsp);

						//v3DispStream("buy");

						bv = 0; 

					}else{


						if(ptLastPrice < v3_out[prevTsp]['buy']['p']){

							xxPerc = (v3_out[prevTsp]['buy']['p'] * 100) / ptLastPrice;

						}else{

							xxPerc = (ptLastPrice * 100) / v3_out[prevTsp]['buy']['p'];
						}


						$('#wssStatus').html(ptLastPrice + '--' + v3_out[prevTsp]['buy']['p']+'--'+xxPerc)
						//priceTicker(v3_out[prevTsp]['buy']['p'], 1);
					}



				}


				//sell
				if("sell" in v3_out[prevTsp]){

					if( v3_out[prevTsp]['sell']['v'] >= limVol){ 

						sp    = v3_out[prevTsp]['sell']['p']; 
						sv    = v3_out[prevTsp]['sell']['v'];
						sc    = v3_out[prevTsp]['sell']['c'];
					//	sperc = v3_out[prevTsp]['sell']['perc'];

						sp = 0-sp; 
						sv = 0-sv;
					    priceTicker(sp);
						volTicker(sv);
						addTradeList(sp, sv, prevTsp);

						//v3DispStream("sell");

						sv = 0;

					}else{

						
						if(ptLastPrice < v3_out[prevTsp]['sell']['p']){

							xxPerc = (v3_out[prevTsp]['sell']['p'] * 100) / ptLastPrice;

						}else{

							xxPerc = (ptLastPrice * 100) / v3_out[prevTsp]['sell']['p'];
						}


						$('#wssStatus').html(ptLastPrice + '--' + v3_out[prevTsp]['sell']['p']+'--'+xxPerc)

					}

				}

								



			}

			prevTsp = tsp; 


}

// function v3DispStream(t){





// 	if(dsI==0){

// 		html = '<div id="t3_left"></div>';

// 		$('.statContainer').html("");

// 		$('.statContainer').append(html);

// 		dsI++;

// 	}

//     ds_prevTsp = prevTsp.toString();
//     ds_prevTsp = ds_prevTsp.substr(0, 10);
// 	dt.setTime(ds_prevTsp*1000);
// 	h   = dt.getUTCHours().toString(); if(h.length<2){h='0'+h;}
// 	m   = dt.getUTCMinutes().toString(); if(m.length<2){m='0'+m;}
// 	s   = dt.getUTCSeconds().toString();if(s.length<2){s='0'+s;}
// 	dy  = dt.getUTCDate().toString();
// 	mth = (dt.getUTCMonth()+1).toString();if(mth.length<2){mth='0'+mth;}
// 	hms = h+':'+m+':'+s+'   '+dy+'-'+mth;


// 	if(t=="buy"){

// 		tBvol = tBvol + bv; 
// 		tBc = tBc + bc; 

// 		ds_p = bp; 
// 		ds_v = bv; 
// 		ds_c = bc;
// 		ds_perc = bperc; 

// 	}



// 	if(t=="sell"){

// 		tSvol = tSvol + Math.abs(sv); 
// 		tSc = tSc +sc; 

// 		ds_p = Math.abs(sp); 
// 		ds_v = Math.abs(sv); 
// 		ds_c = sc;
// 		ds_perc = sperc; 

// 	}



// 	//calculate % of different in vol,  in cicles
// 	if(tBvol>tSvol){ vPer = (tSvol*100)/tBvol; vPer = 100-vPer; tVcolor=buyColor;}
// 	else{ vPer = (tBvol*100)/tSvol; vPer = 100-vPer; tVcolor=sellColor;}

// 	if(tBc>tSc){ cPer = (tSc*100)/tBc; cPer = 100-cPer; tCcolor=buyColor;}
// 	else{ cPer = (tBc*100)/tSc; cPer = 100-cPer; tCcolor=sellColor;}

// 	vPer = Math.round(vPer*10)/10;
// 	cPer = Math.round(cPer*10)/10;
// 	tBvol= Math.round(tBvol*10)/10;
// 	tSvol= Math.round(tSvol*10)/10;
// 	ds_v= Math.round(ds_v*10)/10;

// 	//color price
// 	if(prevP>0 && prevP<ds_p){ dspColor = buyColor; } else { dspColor = sellColor;}
//     if(prevP>0 && prevP==ds_p){ 
//     	if(t=="buy"){dspColor = buyColor;}
// 		if(t=="sell"){dspColor = sellColor;}
//     }


//     //color vol
//     if(tBvol>tSvol){ tbColor = buyColor;}else{tbColor = sellColor;}

//     if(ds_v>=10){ tW = "bold";}else{ tW="";}



//     //color cicles
//     if(tBc>tSc){ tcColor = buyColor;}else{tcColor = sellColor;}






//     prevP = ds_p;
      


// 	html = '<div>'

// 				+ '<div>'+hms+'</div>'
// 				+ '<div>'+t+'</div>'

// 				+ '<div style="color:'+dspColor+';">'+ds_p+'</div>'
// 				+ '<div style="font-weight:'+tW+';">'+ds_v+'</div>'
// 				+ '<div>'+ds_perc+'</div>'
// 				+ '<div>'+ds_c+'</div>'

// 				+ '<div style="color:'+tbColor+';">'+tBvol+'</div>'
// 				+ '<div style="color:'+tbColor+';">'+tSvol+'</div>'
// 				+ '<div style="color:'+tbColor+';">'+vPer+'</div>'

// 				+ '<div style="color:'+tcColor+';">'+tBc+'</div>'
// 				+ '<div style="color:'+tcColor+';">'+tSc+'</div>'
// 				+ '<div style="color:'+tcColor+';">'+cPer+'</div>'



// 		    +'</div>';


// 	$('#t3_left').append(html);


// 		if(translationState ==0){
// 			scrH  = $('#t3_left')[0].scrollHeight; 

// 		            $('#t3_left').scrollTop(scrH);
// 		}

// }


