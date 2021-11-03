/*terminal v4 delta, cumulative delta.
*/


var totBID = 0; var totASK=0;
//real vol
var rb = 0; var rs = 0;
//fake  vol
var fakeb =0; var fakes = 0;

var cmltDelta = 0; 

var unqBID = {}; var unqASK = {};


var timeStart = 0; var timeEnd = 0; var tse = 0;


function utc(utmsp){

	dt.setTime(utmsp*1000);

	h         = dt.getUTCHours(); 
	m         = dt.getUTCMinutes(); 
	s         = dt.getUTCSeconds();
	dy        = dt.getUTCDate();
	mth       = dt.getUTCMonth()+1;
	yr        = dt.getUTCFullYear();


	return h+ ":" +m;

	

}


function terminalV4(){

		

	if(typeof tOrder !== "undefined"){

		prc  = Math.abs(price);
		vl   =  Number(Math.abs(vol));
		type = tOrder;
		timestamp = timestamp.toString(); 
		timestamp = parseInt(timestamp.substr(0, 10));






		if(tse==0) {timeStart = timestamp; timeEnd = timestamp + 900; tse=1;}









		if(timestamp>timeEnd){

			

			for (k in unqBID) {

				if(unqBID[k]==1){ rb += Number(k)}else{ fakeb+=(Number(k)*unqBID[k])}
			}


			for (kk in unqASK) {

				

				if(unqASK[kk]==1){ rs += Number(kk)}else{ fakes+=(Number(kk)*unqASK[kk]); 
				

				}
			}


		   console.log(utc(timeStart) + " "+ utc(timeEnd)+ " "+Math.round(rb)+ " "+Math.round(rs)+ ", "+Math.round(fakeb)+ " "+Math.round(fakes))


		    rb= 0
		    rs= 0
		    fakeb= 0
		    fakes = 0

		    unqBID={}
		    unqASK = {}


			tse = 0;

		}else{

			if(type=="buy"){
				
				if(vl in unqBID){ unqBID[vl] +=1 }else{ unqBID[vl] =1 }

					

			}else{

				if(vl in unqASK){ unqASK[vl] +=1 }else{ unqASK[vl] =1 }

					
			}

		}

		


	}


}

