var b                    = 0;
var www                    = 0; 
var tBuyVol              = 0;
var tSellVol             = 0; 
var tBuySum              = 0;
var tSellSum             = 0;
var tBuyOrders           = 0;
var tSellOrders          = 0; 


function helperTrade() {

    hPrice = Math.abs(price);
    console.log(vol)

    if(vol > 0) {
      tBuyOrders++; 
      tBuyVol = Math.round((tBuyVol + vol) *100000000) / 100000000; 
      tBuySum = Math.round((tBuySum + hPrice * vol)*100)/100;
      buySum  = Math.round((hPrice * vol)*100)/100;
      buyPrice = hPrice; 

       $('#tBuyVol').html(tBuyVol);
       $('#tBuySum').html(tBuySum); 
       $('#buyPrice').html(hPrice); 
       $('#b').html(tBuyOrders);

      // console.log(buyPrice);

    }else{
      

      tSellVol = Math.round((tSellVol + Math.abs(vol)) *100000000) / 100000000; 
      tSellSum = Math.round((tSellSum + hPrice * Math.abs(vol))*100)/100;
      sellSum  = Math.round((hPrice * Math.abs(vol))*100)/100;
      sellPrice = hPrice;

   

       tSellOrders++;

       $('#tSellVol').html(tSellVol);
       $('#tSellSum').html(tSellSum); 
       $('#sellPrice').html(hPrice); 
       $('#s').html(tSellOrders);
      

    }


        //disbalance 
        dPrice = Math.round((100 - (sellPrice * 100) / buyPrice) * 100) / 100 ; 

        dVol = Math.round((100 - (tSellVol * 100) / tBuyVol) * 100) / 100 ; 

        dSum = Math.round((100 - (tSellSum * 100) / tBuySum) * 100) / 100 ; 

        $('#dPrice').html(dPrice);
        $('#dVol').html(dVol);       
        $('#dSum').html(dSum);



        //hPrice % 

         dayHighLowPerc = ((dayHigh*100)/dayLow)-100; 
         dayHighLowPerc = Math.round(dayHighLowPerc*100)/100; 

         hPricePerc = ((hPrice*100)/dayLow)-100; 
         hPricePerc = Math.round(hPricePerc*100)/100; 


          dHL =  dayHigh - dayLow; 
          dPL =  hPrice - dayLow; 

          hPricePerc100 = (dPL * 100)/dHL; 
          hPricePerc100 = Math.round(hPricePerc100*100)/100; 



          hPriceHtml  = dayHighLowPerc+'&nbsp;&nbsp;'+hPricePerc+'&nbsp;&nbsp;'+hPricePerc100


         $('#priceDay').html(hPriceHtml);
         $('title').html(hPriceHtml);



}


var dayHigh;
var dayLow;
var dayVol;
var lastBid;
var lastBidVol;
var lastAsk;
var lastAskVol; 


function helperTicker(){

  $('#lastBidVol').html(lastBidVol); 
  $('#lastAskVol').html(lastAskVol); 
  $('#dayHigh').html(Math.round(dayHigh*100)/100); 
  $('#dayLow').html(Math.round(dayLow*100)/100); 

}





