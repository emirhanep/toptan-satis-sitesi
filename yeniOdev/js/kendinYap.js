function kapat() {
    $("#kndnYpLyrDty").hide();
   $("#kndnYpLyr").hide();
   $(".ktgrScm").show();
   $("#kndnYpHmmdeAln").html(''); 
   $("#kndnYapTeklif").html(""); 
}

function getHammddeErr(err){
    $("#errPlace").html(err);
}


function getHammadeeSccs(resp){
    $("#kndnYpHmmdeAln").html(''); 
    //$(".ktgrScm").hide();
   var response = resp["resp"];
   
   for(var i = 0; i < response.length; i++) { 
    var satir = '<div style="margin-top:10px; border:1px solid black; display:flex; padding-top: 5px; padding-bottom: 5px;"><div class="col-md-5 text-right">'+response[i]["adi"]+'  </div>'+
    '<div class="col-md-5"><input type="number" data-idsi="'+response[i]["id"]+'" class="form-control-plaintext kndnYpHmmdeAdt"  placeholder="Adet" value="0"></div>'+
    '<div class="col-md-2 text-left"></div></div>';
    $('#kndnYpHmmdeAln').append(satir);
   }
   satir = '<div class="col-md-12 text-center" style="margin-top:15px;"><button type="button"  id="kndnYapGetTklfBtn" class="btn btn-info">Teklif Al</button></div>';
   $('#kndnYpHmmdeAln').append(satir);
}

function gethammaddeList() {
    var urlimiz = "qrry/sepet.php";
    var hammadde = $("#kndnKtgr").val();
    var adet = $("#kndnAdet").val();
    postData.push({name: "hammadde", value: hammadde});
    postData.push({name: "adet", value: adet});
    postData.push({name: "type", value: "getHammade"});
    SendPostJson(postData,urlimiz,getHammadeeSccs,getHammddeErr);
}

function getTeklifScss(resp){
    var response = resp["resp"];
    $("#kndnYapTeklif").html(response); 
}

$(".kendinYap").on("click",  function(){  
  $("#kndnYapTeklif").html(""); 
    $("#errPlace").html("");
    $("#kndnYpLyrDty").show();
    $("#kndnYpLyr").show();
      
 });

 $("#kndnSlct").on("change",  function(){  
    var deger = $(this).val();
    var text = $( "#kndnSlct option:selected" ).text();
    $("#kndnKtgr").val(deger); 
    $("#kndnYapHeader").html(text);
        
  });

  $("#KndnYpKapa").on("click",  function(){   
    kapat();
     
  }); 
  $(".addKnypKtgr").on("click",  function(){  
    $("#errPlace").html("");
    gethammaddeList();
  });

  $("#kndnYpHmmdeAln").on("click", "#kndnYapGetTklfBtn", function(){  
    $("#errPlace").html("");
    var scmArryId = [];
    var scmArryVal = [];
    var arrydgr = 0; 
    var gercekAdet = $("#kndnAdet").val();
    var anaKtgr = $("#kndnKtgr").val(); 
    var urunAdi = $("#kndnYapHeader").html();
    $("#kndnYpHmmdeAln input").each(function(){ 
        var idsi = $(this).attr("data-idsi");
        var val = $(this).val();
        scmArryId[arrydgr] = idsi;
        scmArryVal[arrydgr] = val;
        arrydgr++;
    });
    var urlimiz = "qrry/sepet.php";
    postData.push({name: "urunAdi", value: urunAdi});
    postData.push({name: "idler", value: scmArryId});
    postData.push({name: "adetler", value: scmArryVal});
    postData.push({name: "grckAdet", value: gercekAdet});
    postData.push({name: "type", value: "getTeklif"}); 
    SendPostJson(postData,urlimiz,getTeklifScss,getHammddeErr); 
    
  }); 

  $("#kndnYapTeklif").on("click", "#kndnYapSptEkle", function(){  
      $("#errPlace").html("");
      var scmArryId = [];
      var scmArryVal = [];
      var arrydgr = 0; 
      var gercekAdet = $("#kndnAdet").val();
      var anaKtgr = $("#kndnKtgr").val(); 
      var urunAdi = $("#kndnYapHeader").html();
      $("#kndnYpHmmdeAln input").each(function(){ 
          var idsi = $(this).attr("data-idsi");
          var val = $(this).val();
          scmArryId[arrydgr] = idsi;
          scmArryVal[arrydgr] = val;
          arrydgr++;
      });
      var urlimiz = "qrry/sepet.php";
      postData.push({name: "urunAdi", value: urunAdi});
      postData.push({name: "idler", value: scmArryId});
      postData.push({name: "adetler", value: scmArryVal});
      postData.push({name: "grckadet", value: gercekAdet});
      postData.push({name: "ktgrsi", value: anaKtgr});
      postData.push({name: "type", value: "addTklf"}); 
      SendPostJson(postData,urlimiz,getSepetDeatilsScss,getHammddeErr); 
  }); 
  