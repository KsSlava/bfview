
var translationState = 0; //default 0 - from wss; 1- from file/api; 


var wssUrl  = "wss://api.bitfinex.com/ws/2"; 

var tStart = 0; var tEnd =0; var mv = 0; 


var href        = window.location.href;
var url         = new URL(href);
var symbol      = url.searchParams.get("s"); //symbol ex. "BTCUSD"
var csvFileName = url.searchParams.get("f"); //read order from fileName. if no file - try get data from API
var terminal    = url.searchParams.get("t"); // 0 - price terminal, 1 - vol terminal,  null - price & vol terminal
var period      = url.searchParams.get("p"); // in sec  60, 300, 600, 900, 1800, 3600, 14400, 
var dayTrade    = Number(url.searchParams.get("d"));
var exchange    = url.searchParams.get("ex") // 0 - bitfinex, 1 - bitstamp
    tStart      = url.searchParams.get("start"); // get orders from start date ex. 01-12-2019
    tEnd        = url.searchParams.get("end"); //to end date
var limVol      = url.searchParams.get("lm"); // sort by vol limit
    mv       = url.searchParams.get("mv"); //max vol (for correct displaying vol), agrigate calculation
var ag       = url.searchParams.get("ag");  //agrigate 
 

csvFileName = csvFileName.toString();

var id; var timestamp; var vol; var price; var tOrder;              


function bfxTrade(){




  msg =  {   
    event: "subscribe",
    channel: "trades",
    symbol:"t"+symbol.toUpperCase()
  }

  wss = new WebSocket(wssUrl);
  snd = JSON.stringify(msg); 

  wss.onopen = function() {

    document.getElementById('wssStatus').style.backgroundColor= "green";
    wss.send(snd);

  };


  wss.onclose = function(event) {


    if (event.wasClean) {
    //console.log('Соединение закрыто чисто');
    document.getElementById('wssStatus').style.backgroundColor= "orange";
    } else {
    //console.log('Обрыв соединения'); // например, "убит" процесс сервера
    document.getElementById('wssStatus').style.backgroundColor= "red";

    }
    //console.log('Код: ' + event.code + ' причина: ' + event.reason); 
    setTimeout(function(){  bfxTrade()   }, 5000);

  };


  wss.onmessage = function(event) { 

    if(translationState==0){
      d = JSON.parse(event.data);

    

      if(d[1]=="tu"){

        arr       = d[2];

        id        = arr[0];
        timestamp = arr[1];
        vol       = Math.round(arr[2]*100000000) / 100000000; 
        price     = arr[3];

        
        if(vol < 0) { 

          $('title').html(symbol+' '+price+' S');

          price = 0 - price;

          tOrder = "sell";

        

        }else{

          price = price;

          tOrder = "buy";

          $('title').html(symbol+' '+price+' B');

         

        }

        if(terminal.length>=1){

          if(terminal==0) {

          priceTicker(price);
          volTicker(vol);
          addTradeList(price, vol, timestamp);
          helperTrade();
          }


          if(terminal==1){

          cluster();

          }


          if(terminal==3){

             terminalV3();
                   
          }


          if(terminal==4){

             terminalV4(); 
                   
          }

        }else{

          priceTicker(price);
          volTicker(vol);
          addTradeList(price, vol, timestamp);
          helperTrade();
          cluster();

        }
      }
    }

  };

  // wss.onerror = function(error) {
  //   console.log("Ошибка " + error.message);
  // };
}



function bitstampTrade(){

    if(symbol=="btcusd"){sbcrb = "live_trades"} else {sbcrb='live_trades_'+symbol}
  pusher = new Pusher('de504dc5763aeef9ff52'),


  tradesChannel = pusher.subscribe(sbcrb),

  tradesChannel.bind('trade', function (data) {

    timestamp =  data.timestamp 
    id        =  data.id
    vol       = Math.round(data.amount*100000000) / 100000000; 
    price     = Math.round(data.price*10) / 10; 

    if(data.type=="1"){

      price  = 0 - price ; 
      vol    = 0 - vol;
      tOrder = "sell";
    }else{

      price  = price; 
      vol    = vol;
      tOrder = "buy";
    }

    if(terminal.length>=1){

      if(terminal==0) {

        priceTicker(price);
        volTicker(vol);
        addTradeList(price, vol, timestamp);
        helperTrade();

      }

      if(terminal==1){

        cluster();

      }

      if(terminal==3){

        terminalV3();
             
      }


      if(terminal==4){

             terminalV4(); 
                   
      }

    }else{

      priceTicker(price);
      volTicker(vol);
      addTradeList(price, vol, timestamp);
      helperTrade();
      cluster();


    }


  });

}


$(document).ready(function(){

  if(exchange==0){ bfxTrade(); }
  if(exchange==1){ bitstampTrade(); }
    
});




