<script type="text/javascript">
/*terminal v4 delta, cumulative delta.
*/


var totBID = 0; var totASK=0;
//real vol
var rb = 0; var rs = 0;
//fake  vol
var fakeb =0; var fakes = 0;

var cmltDelta = 0; 

var unqBID = {}; var unqASK = {}; 

//unique timestamp
var utb ={}; var uts ={}; var utbr = 0; var utsr = 0; var utbf = 0; var utsf = 0;

var prcStart = 0;




var timeStart = 0; var timeEnd = 0; var tse = 0;


function utc(utmsp, format){

	dt.setTime(utmsp*1000);

	h         = dt.getUTCHours(); 
	m         = dt.getUTCMinutes(); 
	s         = dt.getUTCSeconds();
	dy        = dt.getUTCDate();
	mth       = dt.getUTCMonth()+1;
	yr        = dt.getUTCFullYear();
	d         = dt.getUTCDay();


	if(format=="hm"){

		return h+ ":" +m;

	}


	if(format=="m"){

		return m;

	}

	if(format=="h"){

		return h;

	}



    if(format=="d"){

		return d;

	}		

}


var ste = 0; 

console.log(period)







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



function results(){

	for (k in unqBID) {

		if(unqBID[k]==1){ rb += Number(k)}else{ fakeb+=(Number(k)*unqBID[k])}
	}


	for (kk in unqASK) {

		

		if(unqASK[kk]==1){ rs += Number(kk)}else{ fakes+=(Number(kk)*unqASK[kk]); 
		

		}
	}



	for (k in utb) {

		if(utb[k]==1){ utbr += 1 }else{ utbf +=utb[k]}
	}


	for (k in uts) {

		if(uts[k]==1){ utsr += 1 }else{ utsf +=uts[k]}
	}


 console.log(timeStart +" "+timeEnd+", "+utc(timeStart, "hm") + " "+ utc(timeEnd, "hm")+ " "+Math.round(rb)+ " "+Math.round(rs)+ ", "+Math.round(fakeb)+ " "+Math.round(fakes)+",  "+utbr+" "+utsr+",  "+utbf+" "+utsf)

}

function terminalV4(){

		


	if(typeof tOrder !== "undefined"){

		prc  = Math.abs(price);
		vl   =  Number(Math.abs(vol));
		type = tOrder;
		timestamp = timestamp.toString(); 
		timestamp = parseInt(timestamp.substr(0, 10));


		if(tse==0) { timeStart = timestamp; timeEnd = setTimeEnd(timestamp); prcStart = prc; tse=1;}

	

		if(timestamp >= timeEnd){

		

			if(translationState==1) {

				results()
			}




			// h = '<tr>';

			// 	h += 	'<td>'+utc(timeStart)+" - "+utc(timeEnd)+'</td>';

			// 	h += 	'<td>'+prcStart+" "+prc+'</td>';

			// 	h += 	'<td>'+Math.round(rb)+ " "+Math.round(rs)+'</td>';

			// 	h += 	'<td>'+Math.round(fakeb)+ " "+Math.round(fakes)+'</td>';

			// 	h += 	'<td>'+utbr+ " "+utsr+'</td>';

			// 	h += 	'<td>'+utbf+ " "+utsf+'</td>';

			// h += 	'</tr>';


			rb= 0; rs= 0; fakeb= 0; fakes = 0; utbr=0; utsr=0; utbf=0; utsf=0;

			unqBID={}; unqASK = {}; utb={}; uts={};

		    tse = 0;

		}else{

			if(type=="buy"){
				
				if(vl in unqBID){ unqBID[vl] +=1 }else{ unqBID[vl] =1 }

				if(timestamp in utb){ utb[timestamp]+=1}else{utb[timestamp]=1}
				

			}else{

				if(vl in unqASK){ unqASK[vl] +=1 }else{ unqASK[vl] =1 }

				if(timestamp in uts){ uts[timestamp]+=1}else{uts[timestamp]=1}

					
			}


			if(translationState==0){

				results()

				rb= 0; rs= 0; fakeb= 0; fakes = 0; utbr=0; utsr=0; utbf=0; utsf=0;
			}


		}

		


	}


}





</script>




