trades = [], gaps ={} 

trades.push(["1000", "buy", "0"])
trades.push(["1000", "sell", "0"])

trades.push(["1000", "buy", "0"])
trades.push(["1000", "sell", "0"])

 trades.push(["1000", "buy",  "1"])
 trades.push(["1000", "sell",  "2"])

 trades.push(["1000", "sell", "2"])
 trades.push(["1000", "buy",  "3"])


trades.push(["1000", "buy",  "4"])
 trades.push(["1000", "buy", "5"])
  trades.push(["1000", "sell", "6"])



for( t in trades) {

	pr = trades[t][0]
	type = trades[t][1]
	colI = trades[t][2]

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

console.log(gaps)



for(g in gaps){

	for (o in gaps[g]){

		

		//if gap was opened and closed in one timeframe colum
		if(o == gaps[g][o]){


		}


		//if gap was opened and closed in differents timeframes colums
		if(o < gaps[g][o]){



		}


	    //if gap is open
		if("--" == gaps[g][o]){



		}


	}

}


s = "0.5888";

console.log( Number(s) )