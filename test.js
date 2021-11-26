
function x1(){

	return new Promise(function(resolve, reject){

	  	setTimeout(function(){ r = 'good'; resolve(r);}, 2000)
  
	})

}



function x2(){

	return new Promise(function(resolve, reject){

	  	setTimeout(function(){ r = 'very good'; resolve(r);}, 2000)
  
	})
}








function y1(){

	x1().then(function(){  y2();  console.log("goo");	})
}



function y2(){ 

	x2().then(function(e){ y1();  console.log("very"); })

}


c=0
while(true){

	c++;

	console.log(c)

	if (c==5) {break}
}



















	

	

	
