<?php include("header.php");
include("ekler/fonksiyonlar.php"); 
$dataAdi = "sepet";

$sepetDataKolonlar = array('id', 'kullanici', 'urun', 'adet', 'duzmaliyet', 'grckmlyt', 'tplmbdel', 'tur', 'bag', 'drm', 'alverno');
$sepetDataKolonOlculer = array('int', 'int', 'int', 'int', 'dcml', 'dcml', 'dcml', 'int', 'int', 'int', 'varc');
sqlDurumuBak($dataAdi, $sepetDataKolonlar, $sepetDataKolonOlculer);  ?>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Bakkal Yönetim</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <!-- <div class="profile clearfix">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>John Doe</h2>
              </div>
            </div> -->
            <!-- /menu profile quick info -->

            <br />

            <?php include("menu.php"); ?>

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <!-- <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a> -->
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>AlışVeriş <small>İşlemleri</small></h3>
              </div>

              
            </div>

            <div class="clearfix"></div>

            <div class="row">
              

              

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Alışveriş <small>Listesi</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                        <th class="text-center align-middle">AlisVeris No</th>
                        <th class="text-center align-middle">Kullanıcı</th>
                          <th class="text-center align-middle">Normal Tutarı</th>
                          <th class="text-center align-middle">İndirimli Tutarı </th>
                          <th class="text-center align-middle">Durumu</th>
                          <th class="text-center align-middle">Detay</th>
                          
                          
                         
                          
                        </tr>
                      </thead>
                      <tbody>
                       <?php 
                        if(isset($_REQUEST["kid"])) { 
                            $kid =  $_GET["kid"];
                            $kistas = "`kullanici` = '$kid' && `alverno` != ''  ORDER BY `sepet`.`id` DESC";
                            
                        } else {
                            $kistas = "`alverno` != ''  ORDER BY `sepet`.`id` DESC";
                        }
                        $alverArry = array();
                        $queryBilgiAl = "SELECT  DISTINCT `alverno` FROM `sepet` WHERE $kistas"; 
                        $sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl); 
                        while($row = mysqli_fetch_array($sonucBilgiAl)) { 
                          
                            array_push($alverArry, $row["alverno"]); 
                        }
                        $sonucBilgiAl->close();

                        foreach ($alverArry as $key => $value) {
                            $kistas = "`alverno` = '$value'";
                            $sepetBilgiAry = bilgiGetirArray("sepet", $kistas);
                            $sepetUsrId = $sepetBilgiAry["kullanici"];
                           
                            $kistasUsr = "`id` = '$sepetUsrId'";
                            $userIDArry = bilgiGetirArray("kullanici", $kistasUsr);
                            $userIsim = $userIDArry["isim"]." ".$userIDArry["soyad"];
                            $normTtr  = getSubTotal("sepet",$kistas,"duzmaliyet");
                            $indrmliTtr  = getSubTotal("sepet",$kistas,"tplmbdel");
                            $status = "Ödeme Alındı";
                            if($sepetBilgiAry["drm"] == 2) { $status = "Hazırlanıyor"; }
                            if($sepetBilgiAry["drm"] == 3) { $status = "Kargoda"; }
                            if($sepetBilgiAry["drm"] == 4) { $status = "Teslim Edildi"; }

                            echo '<tr>
                            <td class="text-center align-middle">'.$value.'</td>
                            <td class="text-center align-middle">'.$userIsim.'</td>
                            <td class="text-center align-middle">'.$normTtr.'</td>
                            <td class="text-center align-middle">'.$indrmliTtr.'</td>
                            <td class="text-center align-middle">'.$status.'</td>
                            
                            <td class="text-center align-middle"><button type="button"  data-id="'.$value.'" data-alici="'.$userIsim.'" class="btn btn-primary btn-xs getDteail">Detay</button></td>
                            </tr>'; 
                        }

                       
                        
                       ?>
                        
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>

              

              

              
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
          <a href="index.php" class="site_title"><i class="fa fa-paw"></i> <span>Yönetim</span></a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    <?php include("modal.php"); ?>
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
    <script src="js/mainfunctions.js"></script>
    <script>
       var sepetUserisim = "";
       var alverno = "";
function getBasketDtlErr(err){ alert();
    var modalBdy = '<div id="errPlace" style="width:100%; color:#e74a3b; text-align:center; margin-bottom:20px;">'+err+'</div></div>';
    var modalNameText = 'AlışVeri Detayı';
                    var btnArry = ["","Kapat","",""];
                    var btnColorArry = ["btn-primary addDiscount","btn-secondary","btn-secondary",""];
                    var btnCancel = "modalbttn2";
                    modalPlacement(btnArry,btnColorArry,btnCancel,modalNameText,modalBdy);
}

function getBasketDtlSccs(resp){
    var sepetTplm = parseInt(resp["sptTplm"]); 
    var sptDtyArry = resp["sptDtyArryNrml"]; 
    var resimArray = resp["resimArrayNrml"];
    var isimArray = resp["isimArray"]; 
    var kodArray = resp["kodArray"]; 
    var indirimsiz = resp["indirimsiz"]; 
    var kndnYpKtgrDtyArry = resp["kndnYpKtgrDtyArry"]; 
    var kndnYpresimArray = resp["kndnYpresimArray"]; 
    var kndnYpisimArray = resp["kndnYpisimArray"]; 
    var kndnYapAltStrArry = resp["kndnYapAltStrArry"]; 
    var kndnYapAltStrRsmArry = resp["kndnYapAltStrRsmArry"]; 
    var kndnYapAltStrIsimArry = resp["kndnYapAltStrIsimArry"]; 
    var line = "";
                for(var s = 0; s < sptDtyArry.length; s++)  
                { 
                    line = line + '<tr>' +
                    '<td class="text-center align-middle"><img src="../productImages/'+resimArray[s]+'" width="50" alt=""></td>' +
                    '<td class="text-center align-middle">'+isimArray[s]+'</td>' +
                    '<td class="text-center align-middle">'+sptDtyArry[s]["adet"]+
                    '<td class="text-center align-middle">'+sptDtyArry[s]["duzmaliyet"]+' TL</td>'+
                    '<td class="text-center align-middle">'+sptDtyArry[s]["tplmbdel"]+' TL</td>'+
                    '</tr>';
                }

                for(var s = 0; s < kndnYpKtgrDtyArry.length; s++) 
                    {  
                        line = line + '<tr>' +
                        '<td class="text-center align-middle"><img src="../productImages/'+kndnYpresimArray[s]+'" width="50" alt=""></td>' +
                        '<td class="text-center align-middle"><b>'+kndnYpisimArray[s]+'</b></td>' +
                        '<td class="text-center align-middle">'+kndnYpKtgrDtyArry[s]["adet"]+
                        '<td class="text-center align-middle">0.00 TL</td>'+
                        '<td class="text-center align-middle">0.00 TL</td>'+
                        '</tr>';
                        var altAryim = kndnYapAltStrArry[kndnYpKtgrDtyArry[s]["id"]];
                        for(var as = 0; as < altAryim.length; as++) { 
                            line = line + '<tr>' +
                            '<td class="text-center align-middle"><img src="../productImages/'+kndnYapAltStrRsmArry[as]+'" width="50" alt=""></td>' +
                            '<td class="text-center align-middle">'+kndnYapAltStrIsimArry[altAryim[as]["urun"]]+'</td>' +
                            '<td class="text-center align-middle">'+kndnYpKtgrDtyArry[s]["adet"]+' X '+altAryim[as]["adet"]+
                            '<td class="text-center align-middle">'+altAryim[as]["duzmaliyet"]+' TL</td>'+
                            '<td class="text-center align-middle">'+altAryim[as]["tplmbdel"]+' TL</td>'+
                            '</tr>';
                        }
                    }

    var modalBdy = '<div class="col-md-3"><b>AlışVeriş Sahibi : </b></div><div class="col-md-3">'+sepetUserisim+'</div>' + 
    '<div class="col-md-3"><b>AlışVeriş No : </b></div><div class="col-md-3">'+alverno+'</div>' + 
    '<div class="col-md-3" style="padding-bottom: 20px;"><b>İndirimsiz Toplam : </b></div><div class="col-md-3">'+sepetTplm.toLocaleString() + ' TL</div>' + 
    '<div class="col-md-3" style="padding-bottom: 20px;"><b>İskontolu Toplam : </b></div><div class="col-md-3">'+indirimsiz.toLocaleString() + ' TL</div>' + 
    '<table  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">'+
    '<thead><tr><th class="text-center align-middle">Resim</th><th class="text-center align-middle">Ürün Adı</th><th class="text-center align-middle">Adet</th>'+
    '<th class="text-center align-middle">İndirimsiz Tutarı </th><th class="text-center align-middle">İskontolu Tutar</th></tr></thead>'+
    '<tbody>'+
    line +
    '</tbody></table>'+
    '</div>';
    var modalNameText = 'AlışVeri Detayı';
                    var btnArry = ["","Kapat","",""];
                    var btnColorArry = ["btn-primary addDiscount","btn-secondary","btn-secondary",""];
                    var btnCancel = "modalbttn2";
                    modalPlacement(btnArry,btnColorArry,btnCancel,modalNameText,modalBdy);
}

      $(document).ready(function() { 
        $("#datatable-responsive").on("click", ".getDteail", function(){   
           alverno = $(this).attr("data-id"); 
           sepetUserisim = $(this).attr("data-alici");
           postData.push({name: "alverno", value: alverno});
           postUrl = 'qrry/alisverisler.php';
           SendPostJson(postData,postUrl,getBasketDtlSccs,getBasketDtlErr);
        });
       
      });
    </script>
    <!-- /Datatables -->

  
  </body>
</html>