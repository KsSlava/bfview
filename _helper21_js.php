<script type="text/javascript">

// Cluster analis terminal 18-02-2021, infomixks@gmail.com, Kiselevich Vyacheslav



var csv = [];  
var trade = [];

var col = []; cols = []; var total =[]; var stat = []; var gaps = {}; gapColId = 0;

var prsScl = Array(); 
//agrigation of price
var periods = {'5m':300, '15m':900, '30m':1800, '1h':3600, '4h':14400, '1d':86400, '1w':604800, '1y':31536000}; 

var c = 0; var tmsI = 0; var colI = 0; var colI_lock = 0; var prevcolI = 0; var eachMax = 100; var _pr = 0; var _type = 0; var _ticker = 0; var _prev = 0; var topBuyCol_lock = 0; var topSellCol_lock = 0; 

var colorBuy = '#8fbb77'; var colorSell = '#a04b4b';

var id; var timestamp; var timestampMax =0; var price; var vol; var type; var g_timestampMax = 0;  var g_tmsI = 0;

var gi = 0; var g_colI=-1;

var dt = new Date;



var href        = window.location.href;
var url         = new URL(href);
var symbol      = url.searchParams.get("s"); //symbol ex. "BTCUSD"
var csvFile     = url.searchParams.get("f"); //read order from fileName. if no file - try get data from API
var period      = url.searchParams.get("p");
var av      = url.searchParams.get("av");
var prd;
var px = 0; 
var ap =  url.searchParams.get("ap"); 
var apx =  url.searchParams.get("apx");

// minimal vol  vol bars
var mv = 500; 

if(typeof url.searchParams.get("mv") !== null && url.searchParams.get("mv")>0){

	mv = Number(url.searchParams.get("mv"))

}




if(typeof periods[period] == "undefined"){ prd = periods['1d'] }else{ prd = periods[period] }





 




//round price

// xxxxx.??  2       round
// xxxxx.?   1		 round
// xxxxx     0       round
// xxxxx     nopoint  (cut digits after points)
// xxxx?     x1
// xxx??     x10
// xx???     x100



function roundPrice(p, x) {

		//round after point

		if(x=='nopoint'){ m = Math.floor(p);}

		if(x==0){ 	m = Math.round(p * 1) / 1;  }

		if(x>0 && x<10){

			xm = '1'; 

			if(x>0){

				for(i=1; i<=x; i++)

					xm = xm + '0';

			}

			xm = Number(xm)

			m = Math.round(p * xm) / xm;
		}

	    //round before point

		

		if(x=="x1"){ m = Math.ceil(p/1)*1 }
		if(x=="x10"){ m = Math.floor(p/10)*10 }
		if(x=="x100"){ m = Math.floor(p/100)*100 }


        return m;
}

//round vol
function roundVol(v){

	if(av==8) { m =  Math.round(v * 100000000) / 100000000;}
	if(av==7) { m =  Math.round(v * 10000000) / 10000000;}
	if(av==6) { m =  Math.round(v * 1000000) / 1000000;}
	if(av==5) { m =  Math.round(v * 100000) / 100000;}
	if(av==4) { m =  Math.round(v * 10000) / 10000;}
	if(av==3) { m =  Math.round(v * 1000) / 1000;}
	if(av==2) { m =  Math.round(v * 100) / 100;}
	if(av==1) { m =  Math.round(v * 10) / 10;}
	if(av==0) { m =  Math.round(v * 1) / 1;}

	return m
}


function priceScale(i){

	x = 60 //% min and max size of price scale 

	min  =   roundPrice(  i - (i / 100 * x ) , ap) 

	center = roundPrice(i, ap)

	max  =  roundPrice( Number(i) + Number(i-min), ap); 




	// 1 
	if(ap==0 || ap =='nopoint'){

	 y = 1

    }


    if(ap>0 && ap<10){

    //0.1, 0.01, 0.001 etc

		y ='0.'; 

		for (i=1; i<ap; i++)

		{ y = y + '0'; } 

		y=y+'1';

		y= Number(y);
	}


	if(ap=="x1"){ y = 1 }
	if(ap=="x10"){ y = 10 }
	if(ap=="x100"){y = 100 }





	
	
	while(max>=min){

		max = max - y

		max = roundPrice(max, ap)


		total[max]={'vb':0, 'vs':0, 'pb':0, 'ps':0};


		col[max] = {'vb':0, 'vs':0, 'pb':0, 'ps':0, 'scale_b':[], 'scale_s':[]};

		cols[max] = []; 

		stat[max] = {};

		m = max.toString()

		m = m.replace(".", "_")
		
		prsScl.push(m);

		

	}
}

function readFile(file){

	csv = [];

	file = "../bfcsv/"+file;

    
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", file, false);
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                var text = rawFile.responseText;

                	rows = text.split("\n")

                    for (k in rows ){

						  csv.push(rows[k].split(","))

                	}

		       
              
            }
        }


    }

   rawFile.send(null);
}


function addTotalCol(){


	//price

	h = '<div id="total">'
	+ '<div>'
	+ '<div class="titleCol">PRICE</div>'
	for (k in prsScl) {
		h += '<div class="price">'+prsScl[k].replace("_", ".") +'</div>'
	}

	h+= '</div>'
	





	//sum
	+ '<div>'
	+ '<div class="titleCol">SUM</div>'
	for (k in prsScl) {

		h += '<div><div class="ts_b" id="ts_b'+prsScl[k]+'"></div><div class="ts_s" id="ts_s'+prsScl[k]+'"></div></div>'

	}
	h+= '</div>'


	//vol
	+ '<div>'
	+ '<div class="titleCol">VOL</div>'
	for (k in prsScl) {

		h += '<div><div class="tv_b" id="tv_b'+prsScl[k]+'"></div><div class="tv_s" id="tv_s'+prsScl[k]+'"></div></div>'

	}
	h+= '</div>'




	+ '</div>'

	return h
}



function addCol(dy){

	colI++;	
	
    hh = '<div>'
       + '<div class="titleCol">'+dy+'</div>';

       for (p in prsScl){

       	hh += '<div><div class="tv_b v_b" id="v_b_'+colI+'_'+prsScl[p]+'"></div><div class="tv_s v_s" id="v_s_'+colI+'_'+prsScl[p]+'"></div></div>'

       }

    hh += '</div>'

    

  

 

    return hh
}

function gap(){

	if(timestamp >= g_timestampMax){ g_tmsI = 0}


	if(g_tmsI==0){ 

	
		g_timestampMax = setTimeEnd(timestamp);

		g_tmsI++; 

		g_colI++;
		
		
	}
   
	

	if(type=="buy"){

		if( typeof gaps[pr+type] == "undefined") {

			gaps[pr+type] = {}

			gaps[pr+type][colI] = colI

			

			gaps[pr+"sell"] = {}

			gaps[pr+"sell"][colI] = '--'

		}else{

            
			//colIose gap s
			len  = Object.keys(gaps[pr+type]).length

			if(len>0){

				last = Object.keys(gaps[pr+type])[Object.keys(gaps[pr+type]).length-1];

				if(gaps[pr+type][last]=="--"){

					gaps[pr+type][last]=colI

				}else{

					
					if(gaps[pr+type][last]<colI) {gaps[pr+type][colI] = colI}
					
				}



				len2 = Object.keys(gaps[pr+"sell"]).length

				last2 = Object.keys(gaps[pr+"sell"])[Object.keys(gaps[pr+"sell"]).length-1];


				if(len2>0){

					
					if(gaps[pr+"sell"][last2]!="--" && gaps[pr+"sell"][last2]<colI){

						gaps[pr+"sell"][colI] = '--'

					}


				}





			} 


		}


	}



	if(type=="sell"){

		if( typeof gaps[pr+type] == "undefined") {

			gaps[pr+type] = {}

			gaps[pr+type][colI] = colI

			gaps[pr+"buy"] = {}

			gaps[pr+"buy"][colI] = '--'

		}else{


			//colIose gap sell
			len  = Object.keys(gaps[pr+type]).length

			
			if(len>0){

				last = Object.keys(gaps[pr+type])[Object.keys(gaps[pr+type]).length-1];

				if(gaps[pr+type][last]=="--"){

					gaps[pr+type][last]=colI

				}else{

					
					if(gaps[pr+type][last]<colI) {gaps[pr+type][colI] = colI}
					
				}


				len2 = Object.keys(gaps[pr+"buy"]).length

				last2 = Object.keys(gaps[pr+"buy"])[Object.keys(gaps[pr+"buy"]).length-1];

				if(len2>0){

					
					
					if(gaps[pr+"buy"][last2]!="--" && gaps[pr+"buy"][last2]<colI){

						gaps[pr+"buy"][colI] = '--'

					}


				}





			} 


		}


	}
}

function utc(utmsp, format){



	dt.setTime(utmsp*1000);

	h         = dt.getUTCHours(); 
	m         = dt.getUTCMinutes(); 
	s         = dt.getUTCSeconds();
	dy        = dt.getUTCDate();
	mth       = dt.getUTCMonth()+1;
	yr        = dt.getUTCFullYear();
	d         = dt.getUTCDay();


	if(format=="hm"){ return h+ ":" +m; }

	if(format=="m"){ return m; }

	if(format=="h"){ return h; }

    if(format=="d"){ return d; }

    if(format=="dy"){ return d+ ":" +y; }		

}



function setTimeEnd(t) {
	
	//period str: 15m, 30m, 1h, 4h, 1d	

	p = period

	if(p=="15m" || p=="30m"){

		p = parseInt(period.replace("m", ""));

		for(i=1;i<100;i++){

			x = p*i;

			if(x>=60) {x=0;}
                     
			if(utc(t,"m") < x){

				break; 
			}

		}

		while(utc(t,"m") != x){	t++;}
	}


	if(p=="1h" || p=="4h"){

		p = parseInt(period.replace("h", ""));

		for(i=1;i<100;i++){

			x = p*i;

			if(x>=24) {x=0;}
                     
			if(utc(t,"h") < x){

				break; 
			}

		}

		while(utc(t,"h") != x){	t++;}

	}

	if(p=="1d"){

		x = utc(t,"d");

		while(utc(t,"d") == x){	t++;}

	}

	//console.log(t +" "+utc(t,"m")+" "+x)



	

	//console.log(timestamp+ " "+t+ " "+x)

	return t; 

}


function gapHTML(){

	gW =  $(".price").css("width")


	gW = (Number(gW.match(/[0-9]+/))+1) * 2

	setInterval(function(){



		for(g in gaps){

			for (o in gaps[g]){

				if(o!="--"){


					//get range of colums
					begin = parseInt(o)
					end   = gaps[g][o]
					if(end !=="--"){ end = parseInt(end) }
					
					
					gpr   = g
					gtype = g
					

					//get price
					gpr = gpr.match(/[0-9]+/)

					//get type
					gtype = gtype.match(/[a-zA-Z]+/)


					
				
	


					//if gap was opened and closed in differents timeframes colums

					if(gi==0){ _if = begin < end}else{_if= begin < end && end == colI; }
					if(_if)  {


					

						new_gW = 0
						
						for(i=begin; i<=end; i++){

						   new_gW = new_gW + gW
				
						}


						new_gW = new_gW - gW/2

						if(gtype=="buy"){

							$('#v_b_' + begin + '_'+gpr).html('<div class="gap_b" style="width:'+new_gW+'px; background:none;"><div class="gap_b_cl"></div></div>"')

						}else{

							$('#v_s_' + begin + '_'+gpr).html('<div class="gap_s" style="width:'+new_gW+'px; background:none;"><div class="gap_s_cl"></div></div>')

						}
					}










				    //if gap is opened
				    if(gi==0){ _if = "--" == end}else{_if= "--" == end }

					if(_if){


						
						new_gW = 0
						
						for(i=begin; i<=colI; i++){

						   new_gW = new_gW + gW
				
						}


						new_gW = new_gW - gW/2

						if(gtype=="buy"){

							$('#v_b_' + begin + '_'+gpr).html('<div class="gap_b" style="width:'+new_gW+'px;"><div class="gap_b_op"></div></div>')

						}else{

							$('#v_s_' + begin + '_'+gpr).html('<div class="gap_s" style="width:'+new_gW+'px;"><div class="gap_s_op"></div></div>')

						}

					}

				}



			}

		}

		// if(gi==0){console.log(gaps)}

		prevcolI = 0

		gi++

		



		

	}, 5000)
}


function _colI(){

	if(colI_lock==0){  colI_lock = 1; }else{ colI++ ;}

	prevcolI = 1
}



function setPeriodData(){

	return new Promise(function(resolve, reject){

		if(c <= (csv.length-1)){

			while(1){

				
				timestamp = parseInt(csv[c][0].substr(0, 10));

				//set period
				if(tmsI==0){ 

					timestampCol = timestamp;

					timestampMax = setTimeEnd(timestamp);

					tmsI++; 

//					console.log(timestamp + " "+ timestampMax+ " "+ utc(timestamp, "hm")+ " "+utc(timestampMax, "hm") )
				
				}


				id = csv[c][1];
				price = csv[c][2];
				vol = Number(csv[c][3]);
				type = csv[c][4];

				pr = roundPrice(price, ap)

			    //gap()
				
		    	

				if(typeof(col[pr]) !== "undefined"){


					cls =  "c"+(colI);


					if(typeof cols[pr][cls] == 'undefined' ){

						cols[pr][cls] = { 'topB':0, 'topS':0, 'volB':0, 'volS':0};

					}


					if(type == "buy"){

						col[pr]['vb'] = roundVol(col[pr]['vb'] + vol)
						col[pr]['pb'] = roundPrice(col[pr]['pb'] + price * vol, apx)

						total[pr]['vb'] = roundVol(total[pr]['vb'] + vol)
						total[pr]['pb'] = roundPrice(total[pr]['pb'] + price * vol, apx)



						//statistic   		
						cols[pr][cls]['topB'] += 1;
						cols[pr][cls]['volB'] = roundVol(cols[pr][cls]['volB'] + vol);

						

		 				//create grid  0...10, ex  10600: 10600, 10601...10609

						if(ap=='x10' && col[pr]['scale_b'].length < 10){

				     		xPr = roundPrice(price, 'nopoint') 

							if(!col[pr]['scale_b'].includes(xPr)){  col[pr]['scale_b'].push(xPr) }

						}

					}


					if(type == "sell"){

						col[pr]['vs'] = roundVol(col[pr]['vs'] + vol);
						col[pr]['ps'] = roundPrice(col[pr]['ps'] + price * vol, apx)

						total[pr]['vs'] = roundVol(total[pr]['vs'] + vol);
						total[pr]['ps'] = roundPrice(total[pr]['ps'] + price * vol, apx)


						//statistic 
						cols[pr][cls]['topS'] += 1;
						cols[pr][cls]['volS'] = roundVol(cols[pr][cls]['volS'] + vol);


						
						if(ap=='x10' && col[pr]['scale_s'].length < 10){

				     		xPr = roundPrice(price, 'nopoint') 

							if(!col[pr]['scale_s'].includes(xPr)){  col[pr]['scale_s'].push(xPr) }

						}

					}

				}



				//stop (end of csv)
				if(c == (csv.length-1) ) {

					resolve();

					tmsI=0;

				//	console.log("stop")

					break;


				}else{

					//next col
					if(timestamp>=timestampMax) {

						resolve();

					//	console.log("next")

						tmsI=0;

						break;
					}

				}


				c++;

			} 

		}

	})
}

function setCol(){

	//create add  col
	
	return new Promise(function(resolve, reject){    	    

	    hh = '<div>'
		   + '<div class="titleCol">'+utc(timestampCol, "hm")+'</div>';

		for (p in prsScl) {

			cp = prsScl[p].replace("_", ".")
			cl = prsScl[p];
		

	  		v_b = col[cp]['vb'];
	  		v_s = col[cp]['vs'];

	  		if(v_b==0){ v_b = '';}
	  		if(v_s==0){ v_s = '';}


	  		scale_b = col[cp]['scale_b']
	  		scale_s = col[cp]['scale_s']

	  		//#6b7a1275
	  		//#914b3e7a

	  		if(scale_b.length == 10){ v_b_class = ' class="tv_b v_b full_b" '; }else{v_b_class=' class="tv_b v_b" ';}
	  		if(scale_s.length == 10){ v_s_class = ' class="tv_s v_s full_s" '; }else{v_s_class=' class="tv_s v_s" ';}


		  	v_b = v_b.toString()
			if(v_b.indexOf(".") !==-1){

				v_b = v_b.replace('.', '<span class="afp_b">.') + '</span>';

			}



		  	v_s = v_s.toString()
			if(v_s.indexOf(".") !==-1){

				v_s = v_s.replace('.', '<span class="afp_s">.') + '</span>';

			}



		  	hh += '<div><div'+v_b_class+' id="v_b_'+colI+'_'+cl+'">'+v_b+'</div><div'+v_s_class+'id="v_s_'+colI+'_'+cl+'">'+v_s+'</div></div>';

		}



		hh += '</div>';






		$('#total').append(hh, resolve())


		//reset col




		if(c !== (csv.length-1)){
		   	for (cl in col){
		   		col[cl] = { 'vb':0, 'vs':0, 'pb':0, 'ps':0, 'scale_b':[], 'scale_s':[] };
		   	}
		}

		colI++

		

	});
}


function setTotCol(){

	//add total col 
	if(c==(csv.length-1)){
		
		h = '<div>'
		+   '<div class="titleCol">PRICE</div>'
		for (p in prsScl) {
			h += '<div class="price">'+prsScl[p].replace("_", ".") +'</div>'
		}

		h+= '</div>'
		

		//sum
		h+= '<div>'
		h+= '<div class="titleCol">SUM</div>'

		for (p in prsScl) {


			t = prsScl[p].replace("_", ".")

			ts = prsScl[p];

			s_b = total[t]['pb'];s_s = total[t]['ps'];
			if(s_b==0){ s_b = "";} if(s_s==0){ s_s = "";}	



			h+='<div><div class="ts_b" id="ts_b'+ts+'">'+s_b+'</div><div class="ts_s" id="ts_s'+ts+'">'+s_s+'</div></div>'; 
		}


		h+= '</div>'


		//vol
		tmpTotalVol = []
		h+= '<div>'
		h+= '<div class="titleCol">VOL</div>'

		for (p in prsScl) {


			t = prsScl[p].replace("_", ".")

			tv = prsScl[p];


			v_b = total[t]['vb']; v_s = total[t]['vs'];

			if(v_b==0){ v_b = "";} if(v_s==0){ v_s = "";}



			v_b = v_b.toString()

			if(v_b.indexOf(".") !==-1){

				v_b = v_b.replace('.', '<span class="afp_b">.') + '</span>';
		

			}



			v_s = v_s.toString()
			if(v_s.indexOf(".") !==-1){

				v_s = v_s.replace('.', '<span class="afp_s">.') + '</span>';
		

			}





			h += '<div><div class="tv_b" id="tv_b'+tv+'">'+v_b+'</div><div class="tv_s" id="tv_s'+tv+'">'+v_s+'</div></div>';

		}

		h+= '</div>'



		//vol bars
		tmpTotalVol = []
		h+= '<div>'
		h+= '<div class="titleCol">VOL BARS</div>'

		for (p in prsScl) {


			t = prsScl[p].replace("_", ".")

			tv = prsScl[p];


			v_b = total[t]['vb']; v_s = total[t]['vs'];


			v_b = (v_b * 100) / mv ;

			v_s = (v_s * 100) / mv ;

		

			h += '<div class="tvb_row"><div class="tvb_b" id="tvb_b'+tv+'" style="width:'+v_b+'%"></div><div class="tvb_s" id="tvb_s'+tv+'" style="width:'+v_s+'%"></div></div>';

		}

		h+= '</div>'

		$('#total').prepend(h)
	}

}


function sc(){ 

	setCol().then(function(){ 

		if(c!==(csv.length-1)){

		//	console.log('sc ' +c + " "+(csv.length-1));

			spd();

			

		}else{



			setTotCol()

	    	if(c==csv.length){

	    		colI--

	    	}
						
		    //gapHTML()


		    setTimeout(function(){ bfxTrade() }, 10000);
		}


		
	}) 

}


function spd(){ 

	setPeriodData().then(function(){ 

		setTimeout(function(){ sc(); //console.log('spd')
		 }, 500) 


	})
}


function displayCsv(){

	if(csvFile.length>5){

		readFile(csvFile)

    	priceScale(csv[0][2])

    	spd();
		

	}else{		

		bfxTrade()
	}
}


function eachLive(){

	//set period
	//add col 
	if(timestamp>=timestampMax){ tmsI = 0 }

	if(tmsI==0){ 
		
		timestampCol = timestamp;

		timestampMax = setTimeEnd(timestamp);

		tmsI++; 

	//	console.log(timestamp + " "+ timestampMax+ " "+ utc(timestamp, "hm")+ " "+utc(timestampMax, "hm") )


		//reset col
    	for (k in col){

    		col[k] = { 'vb':0, 'vs':0, 'pb':0, 'ps':0, 'scale_b':[], 'scale_s':[] };
    	}

		$('#total').append(addCol(dy));

	}

	
	pr = roundPrice(price, ap)

	//gap()


	if(typeof(col[pr]) !== "undefined"){

		if(type == "buy"){

			col[pr]['vb'] = roundVol(col[pr]['vb'] + vol)
			col[pr]['pb'] = roundPrice(col[pr]['pb'] + price * vol, apx)

			total[pr]['vb'] = roundVol(total[pr]['vb'] + vol)
			total[pr]['pb'] = roundPrice(total[pr]['pb'] + price * vol, apx)

			//create grid  0...10, ex  10600: 10600, 10601...10609

			if(ap=='x10' && col[pr]['scale_b'].length < 10){

	     		xPr = roundPrice(price, 'nopoint') 

				if(!col[pr]['scale_b'].includes(xPr)){  col[pr]['scale_b'].push(xPr) }

			}


	    	//display buy 

	    	current =  $('#v_b_'+colI+'_'+pr.toString().replace(".", "_"));

	    	


	    	scale_b = col[pr]['scale_b']
		    		

		    if(scale_b.length == 10){ current.removeClass('full_b'); current.addClass('full_b')}
		    		



    		if(pr !== _pr && _pr !==0){

				 _prev.removeClass('tickerB tickerS'); 

				 current.addClass('tickerB')

    		}else{
  	

    			if( _type == "sell") { _prev.removeClass('tickerS'); current.addClass('tickerB') }


    		}


    		_prev = current 

    		_type = type

    		_pr   = pr

	
	    	


			cr = col[pr]['vb'];

			cr = cr.toString()

			if(cr.indexOf(".") !==-1){

				cr = cr.replace('.', '<span class="afp_b">.') + '</span>';

				

			}

		
	    	current.html(cr)


			$('#ts_b'+pr.toString().replace(".", "_")).html( total[pr]['pb'])

			$('#tv_b'+pr.toString().replace(".", "_")).html( total[pr]['vb'])




			$('#tvb_b'+pr.toString().replace(".", "_")).css( 'width', ((total[pr]['vb'] * 100)/mv)+"%")

			
		}

		 
        

		if(type == "sell"){

			col[pr]['vs'] = roundVol(col[pr]['vs'] + vol);
			col[pr]['ps'] = roundPrice(col[pr]['ps'] + price * vol, apx)

			total[pr]['vs'] = roundVol(total[pr]['vs'] + vol);
			total[pr]['ps'] = roundPrice(total[pr]['ps'] + price * vol, apx)

			if(ap=='x10' && col[pr]['scale_s'].length < 10){

	     		xPr = roundPrice(price, 'nopoint') 

				if(!col[pr]['scale_s'].includes(xPr)){  col[pr]['scale_s'].push(xPr) }

			}



			//display sell

			current = $('#v_s_'+colI+'_'+pr.toString().replace(".", "_"))

		    scale_s = col[pr]['scale_s']		    		

		    if(scale_s.length == 10){ current.removeClass('full_s'); current.addClass('full_s')}



    		if(pr !== _pr && _pr !==0){

				 _prev.removeClass('tickerB tickerS'); 

				 current.addClass('tickerS')

    		}else{
  	

    			if( _type == "buy") { _prev.removeClass('tickerB'); current.addClass('tickerS')}


    		}

    		_prev = current 

    		_type = type

    		_pr   = pr


			cr = col[pr]['vs'].toString();

			if(cr.indexOf(".") !==-1){

				cr = cr.replace('.', '<span class="afp_s">.') + '</span>';

				

			}

		
	    	current.html(cr)

			$('#ts_s'+pr.toString().replace(".", "_")).html( total[pr]['ps'])

			$('#tv_s'+pr.toString().replace(".", "_")).html( total[pr]['vs'])

			$('#tvb_s'+pr.toString().replace(".", "_")).css( 'width', ((total[pr]['vs'] * 100)/mv)+"%")

		}


		//prPrev = pr

	}
}


function displayCsvLive(){

	if(csvFile.length>5){

		readFile(csvFile)

		priceScale(csv[0][2])

		$('#total').append(addTotalCol())	

		var eachInterval = setInterval(function(){


				for(e=0; e<eachMax; e++){

					if( c <= (csv.length-1) ) { 

						timestamp = Number(csv[c][0]);
						id = csv[c][1];
						price = csv[c][2];
						vol = Number(csv[c][3]);
						type = csv[c][4];

						eachLive()


					}else{

						clearInterval(eachInterval);


						bfxTrade()
						
						
						break;



						
					}

					c++;
				}



			


		}, 10)

	}
}

function displayWss(){


	if(colI==0){




		priceScale(price)

		$('#total').append(addTotalCol())

		
	}


	eachLive()
}



function testWSS(){

    csvFile = '28-08-2021---29-08-2021---BTCUSD.csv';
	readFile(csvFile)

		c= 0

		var eachInterval = setInterval(function(){

			

			for(e=0; e<eachMax; e++){

				if( c <= (csv.length-1) ) { 

		            timestamp = Number(csv[c][0]);
		    		id = csv[c][1];
		    		price = csv[c][2];
		    		vol = Number(csv[c][3]);
		    		type = csv[c][4];

					eachLive()


				}else{

					clearInterval(eachInterval);


					
					
					
					break;



					
				}

				c++;
			}



		


	}, 500)
}




</script>









