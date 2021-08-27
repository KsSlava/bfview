

<script type="text/javascript">

function bfxTrade(smb="btcusd"){

  if (symbol.length>3) {smb=symbol;}

  msg = { 

    event:    "subscribe",
    channel:  "trades",
    symbol:   "t"+smb.toUpperCase()

  }

  wss = new WebSocket("wss://api.bitfinex.com/ws/2");
  snd = JSON.stringify(msg); 

  wss.onopen = function() {

    //document.getElementById('wssStatus').style.backgroundColor= "green";
    wss.send(snd);

    console.log('wss')

  };


  wss.onclose = function(event) {


    if (event.wasClean) {
        //console.log('Соединение закрыто чисто');
        //document.getElementById('wssStatus').style.backgroundColor= "orange";
    } else {
        //console.log('Обрыв соединения'); // например, "убит" процесс сервера
       // document.getElementById('wssStatus').style.backgroundColor= "red";

    }
    //console.log('Код: ' + event.code + ' причина: ' + event.reason); 
    setTimeout(function(){  bfxTrade()   }, 5000);

  };


  wss.onmessage = function(event) { 

    d = JSON.parse(event.data);

          if(d[1]=="tu"){

            arr       = d[2];

            id        = arr[0];
            vol       = Number(arr[2]); 
            price     = Number(arr[3]);


            timestamp = arr[1].toString(); 
            timestamp = timestamp.substr(0, 10);
            timestamp = Number(timestamp);


            
            if(vol < 0) { 

              vol = 0 - vol;

              type = "sell";

            }else{

              type = "buy";

            }

           

             displayWss()
          }
  };

  // wss.onerror = function(error) {
  //   console.log("Ошибка " + error.message);
  // };
}



function bitstampTrade(smb="btcusd"){

  if (symbol.length>3) {smb=symbol;}

  msg = { 

    event:    "bts:subscribe",
    data:     {"channel": "live_trades_btcusd"},
  

  }

  wss = new WebSocket("wss://ws.bitstamp.net");
  snd = JSON.stringify(msg); 

  wss.onopen = function() {

    //document.getElementById('wssStatus').style.backgroundColor= "green";
    wss.send(snd);

    console.log('wss bitstamp')

  };


  wss.onclose = function(event) {


    if (event.wasClean) {
        //console.log('Соединение закрыто чисто');
        //document.getElementById('wssStatus').style.backgroundColor= "orange";
    } else {
        //console.log('Обрыв соединения'); // например, "убит" процесс сервера
       // document.getElementById('wssStatus').style.backgroundColor= "red";

    }
    //console.log('Код: ' + event.code + ' причина: ' + event.reason); 
    setTimeout(function(){  bitstampTrade()   }, 5000);

  };


  wss.onmessage = function(event) { 

    d = JSON.parse(event.data);





     if(Object.keys(d.data).length > 0) {

       // console.log(d.data)

        
     

    





            id        = d.data.id;
            vol       = Number(d.data.amount_str); 
            price     = Number(d.data.price_str);


            // timestamp = d.data.timestamp.toString(); 
            // timestamp = timestamp.substr(0, 10);
            timestamp = Number(d.data.timestamp);


            
            if(d.data.type == 1) { 

              type = "sell";

            }else{

              type = "buy";

            }

            // console.log(id)
            // console.log(vol)
            // console.log(price)
            // console.log(type)



            displayWss()
       }  
  };

  // wss.onerror = function(error) {
  //   console.log("Ошибка " + error.message);
  // };
}
</script>






