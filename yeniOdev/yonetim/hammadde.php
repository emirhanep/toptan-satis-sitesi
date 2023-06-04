<?php include("header.php"); 
include("ekler/fonksiyonlar.php");
$idsi = getAl("idsi");
$adi = getAl("adi");
$kistas = "`id` = '$idsi' && `name` = '$adi'";
$varmi = VarmiKontrol("kategoriler", $kistas);
if($varmi == 0) { echo '<script>window.location.href="kategori.php"</script>'; die(); }

?>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Yönetim</span></a>
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
                <h3><?php echo $adi; ?> -- Hammadde <small>İşlemleri</small></h3>
              </div>

              
            </div>

            <div class="clearfix"></div>

            <div class="row">
              

              

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $adi; ?> -- Hammadde <small>Listesi</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    <button type="button" class="btn btn-success btn-xs addNew">+ Yeni</button>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                        <th class="text-center align-middle">No</th>
                          <th class="text-center align-middle">Adi</th>
                          <th class="text-center align-middle">Maliyet(0 Adet)</th>
                          <th class="text-center align-middle">İndrim Oranlar</th>
                          <th class="text-center align-middle">Düzenle</th>
                          <th class="text-center align-middle">Durum</th>
                         
                          
                        </tr>
                      </thead>
                      <tbody>
                       
                        
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
          <a href="index.php" class="site_title"><i class="fa fa-paw"></i> <span>Bakkal Yönetim</span></a>
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
      function GetIndrmSccs(hamSonuc){
            var response = hamSonuc['resp'];
            $('#indirimlerListesi').html('');
            for(var i = 0; i < response.length; i++) { 
                var satir = '<div> Minumum ' + response[i]["minadet"] + ' Adet İndirimi : %' + response[i]["yuzde"] + ' <i class="fa-solid fas-check"></i></div>';
                $('#indirimlerListesi').append(satir);
            }
        }
function getIndirimlerList(idsi){
  postData.push({name: "bag", value: idsi});
  postData.push({name: "tur", value: "2"});
  postUrl = 'qrry/indirimler.php';
  SendPostJson(postData,postUrl,GetIndrmSccs,addNewSplierErr);
}

function addNewSplierErr(err) {
$('#errPlace').html(err);
}


function addNewSplierSccs(hamSonuc) {
  $('#datatable-responsive').DataTable().destroy();
  $('#datatable-responsive').find('tbody').html(''); 
  var response = hamSonuc['resp'];
  for(var i = 0; i < response.length; i++) {
    var yazdeger = 'Aktif';
    var yazClass = 'btn-info';
    if(response[i]['drm'] == 0) { yazdeger = 'Pasif'; yazClass = 'btn-danger'; }
    var satir = '<tr><td class="text-center align-middle">'+ response[i]["id"]+'</td><td class="text-center align-middle">'+ response[i]["adi"]+'</td>'+
    '<td class="text-center align-middle">'+ response[i]["maliyet"]+'</td>'+
    '<td class="text-center align-middle"><button type="button" data-idsi="'+response[i]['id']+'" data-adi="'+response[i]['adi']+'" class="btn btn-warning btn-xs indrmBtn">İndirimler</button></td>' +
    '<td class="text-center align-middle">' +
    '<button type="button" data-idsi="'+response[i]['id']+'" data-adi="'+response[i]['adi']+'" data-maliyet="'+response[i]['maliyet']+'" class="btn btn-primary btn-xs editBtn">Düzenle</button></td><td class="text-center align-middle">'+
    '<button type="button" data-idsi="'+response[i]['id']+'" class="btn '+yazClass+' btn-xs activeBtn">'+yazdeger+'</button></td></tr>';
  $('#datatable-responsive').find('tbody').append(satir);
  }
  $('#datatable-responsive').DataTable().draw();
  $("#newModal").modal('hide');

}

function ilkCalisSccs(hamSonuc) {
  $('#datatable-responsive').DataTable().destroy();
  $('#datatable-responsive').find('tbody').html(''); 
  var response = hamSonuc['resp'];
  for(var i = 0; i < response.length; i++) {
    var yazdeger = 'Aktif';
    var yazClass = 'btn-info';
    if(response[i]['drm'] == 0) { yazdeger = 'Pasif'; yazClass = 'btn-danger'; }
    var satir = '<tr><td class="text-center align-middle">'+ response[i]["id"]+'</td><td class="text-center align-middle">'+ response[i]["adi"]+'</td>'+
    '<td class="text-center align-middle">'+ response[i]["maliyet"]+'</td>'+
    '<td class="text-center align-middle"><button type="button" data-idsi="'+response[i]['id']+'" data-adi="'+response[i]['adi']+'" class="btn btn-warning btn-xs indrmBtn">İndirimler</button></td>' +
    '<td class="text-center align-middle">' +
    '<button type="button" data-idsi="'+response[i]['id']+'" data-adi="'+response[i]['adi']+'" data-maliyet="'+response[i]['maliyet']+'" class="btn btn-primary btn-xs editBtn">Düzenle</button></td><td class="text-center align-middle">'+
    '<button type="button" data-idsi="'+response[i]['id']+'" class="btn '+yazClass+' btn-xs activeBtn">'+yazdeger+'</button></td></tr>';
  $('#datatable-responsive').find('tbody').append(satir);
  }
  $('#datatable-responsive').DataTable().draw();
 
}

$("#datatable-responsive").on("click", ".activeBtn", function(){  
  var idsi = $(this).attr("data-idsi"); 
  postData.push({name: "type", value: 'del'});
  postData.push({name: "idsi", value: idsi});
  postUrl = 'qrry/hammadde.php';
  SendPostJson(postData,postUrl,ilkCalisSccs,addNewSplierErr);
});

function ilkCalis() {
  postUrl = 'qrry/hammadde.php';
  postData.push({name: "kategori", value: <?php echo $idsi; ?>});
  SendPostJson(postData,postUrl,ilkCalisSccs,addNewSplierErr);
}
      $(document).ready(function() {
        ilkCalis();

        $("#newModal .modal-footer").on("click", ".editCategories", function(){    
          $('#errPlace').html('');
          var adi = $('#adi').val();
          var maliyet = $('#maliyet').val();
          var idnedir = $('#idbu').val();
          postData.push({name: "name", value: adi});
          postData.push({name: "maliyet", value: maliyet});
          postData.push({name: "kategori", value: "<?php echo $idsi; ?>"});
          postData.push({name: "idsi", value: idnedir});
          postData.push({name: "type", value: 'update'});
          postUrl = 'qrry/hammadde.php';
          SendPostJson(postData,postUrl,addNewSplierSccs,addNewSplierErr);
        });

        $("#datatable-responsive").on("click", ".editBtn", function(){  
        var idsi = $(this).attr("data-idsi");
        var adi = $(this).attr("data-adi");
        var maliyet = $(this).attr("data-maliyet");
        var modalBdy = '<div id="errPlace" style="width:100%; color:#e74a3b; text-align:center; margin-bottom:20px;"></div>'+
          '<div class="form-group" style="padding-bottom: 10px">'+
                       ' <label class="control-label col-md-3 col-sm-3 col-xs-12" for="adi">Kategori Adı <span class="required">*</span>' +
                        '</label>' +
                        '<div class="col-md-6 col-sm-6 col-xs-12">' +
                          '<input type="text" id="adi" required="required" class="form-control col-md-7 col-xs-12" style="margin-top:-12px;" value="'+adi+ '">' +
                          '<input type="hidden" id="idbu"  value="'+idsi+ '">' +
                       ' </div><div class="clearfix"></div>' +
                       ' <label class="control-label col-md-3 col-sm-3 col-xs-12" style="margin-top:10px;" for="adi">Maliyet <span class="required">*</span>' +
                        '</label>' +
                        '<div class="col-md-6 col-sm-6 col-xs-12">' +
                          '<input type="text" id="maliyet" required="required" class="form-control col-md-7 col-xs-12" style="margin-top:10px;" value="'+maliyet+ '">' +
                          
                       ' </div><div class="clearfix"></div>' +
                       '</div>';

                    var modalNameText = adi + ' Hammadde Düzenleme';
                    var btnArry = ["Düzenle","İptal","",""];
                    var btnColorArry = ["btn-primary editCategories","btn-secondary","btn-secondary",""];
                    var btnCancel = "modalbttn2";
                    modalPlacement(btnArry,btnColorArry,btnCancel,modalNameText,modalBdy);
       
      });

      $("#newModal .modal-footer").on("click", ".addDiscount", function(){   
          $('#errPlace').html('');
          var minAdet = $('#minAdet').val();
          var yuzde = $('#yuzde').val();
          var bag = $('#bag').val();
          var tur = $('#tur').val();
          postData.push({name: "bag", value: bag});
          postData.push({name: "tur", value: tur});
          postData.push({name: "minadet", value: minAdet});
          postData.push({name: "yuzde", value: yuzde});
          postData.push({name: "type", value: 'ekle'});
          postUrl = 'qrry/indirimler.php';
          SendPostJson(postData,postUrl,GetIndrmSccs,addNewSplierErr);
         }); 

      $("#datatable-responsive").on("click", ".indrmBtn", function(){  
        var adi = $(this).attr("data-adi");
            var idsi = $(this).attr("data-idsi");
            var modalBdy = '<div id="errPlace" style="width:100%; color:#e74a3b; text-align:center; margin-bottom:20px;"></div>'+
            '<div id="indirimlerListesi"></div>'+
          '<div class="form-group" style="margin-top:15px; padding-bottom: 10px">'+
                       ' <label class="control-label col-md-3 col-sm-3 col-xs-12" for="adi">Minumum Adet<span class="required">*</span>' +
                        '</label>' +
                        '<div class="col-md-6 col-sm-6 col-xs-12">' +
                          '<input type="number" id="minAdet" required="required" class="form-control col-md-7 col-xs-12" style="margin-top:-12px;" value="0">' +
                       ' </div><div class="clearfix"></div>' +
                       '<div class="form-group" style="margin-top: 15px">'+
                       ' <label class="control-label col-md-3 col-sm-3 col-xs-12" for="adi">Yüzdelik Oran<span class="required">*</span>' +
                        '</label>' +
                        '<div class="col-md-6 col-sm-6 col-xs-12">' +
                          '<input type="number" id="yuzde" required="required" class="form-control col-md-7 col-xs-12" style="margin-top:-12px;" value="0">' +
                          '<input type="hidden" id="bag" value="'+idsi+'"><input type="hidden" id="tur" value="2">' +
                       ' </div><div class="clearfix"></div>' +
                       '</div>';

                    var modalNameText = adi + ' İndirimler';
                    var btnArry = ["Ekle","Kapat","",""];
                    var btnColorArry = ["btn-primary addDiscount","btn-secondary","btn-secondary",""];
                    var btnCancel = "modalbttn2";
                    modalPlacement(btnArry,btnColorArry,btnCancel,modalNameText,modalBdy);
                    getIndirimlerList(idsi);
       
      });

        $(".addNew").on("click",  function(){ 
          var modalBdy = '<div id="errPlace" style="width:100%; color:#e74a3b; text-align:center; margin-bottom:20px;"></div>'+
          '<div class="form-group" style="padding-bottom: 10px">'+
                       ' <label class="control-label col-md-3 col-sm-3 col-xs-12" for="adi">Hammadde Adı <span class="required">*</span>' +
                        '</label>' +
                        '<div class="col-md-6 col-sm-6 col-xs-12">' +
                          '<input type="text" id="adi" required="required" class="form-control col-md-7 col-xs-12" style="margin-top:-12px;">' +
                       ' </div><div class="clearfix"></div>' +
                       '<div class="form-group" style="margin-top: 15px">'+
                       ' <label class="control-label col-md-3 col-sm-3 col-xs-12" for="adi">Maliyeti <span class="required">*</span>' +
                        '</label>' +
                        '<div class="col-md-6 col-sm-6 col-xs-12">' +
                          '<input type="number" id="maliyet" required="required" class="form-control col-md-7 col-xs-12" style="margin-top:-12px;">' +
                          '<input type="hidden" id="ktgrid"  value="'+<?php echo $idsi; ?>+ '">' +
                       ' </div><div class="clearfix"></div>' +
                       '</div>';

                    var modalNameText =  '<?php echo $adi; ?> --- Hammadde Ekleme';
                    var btnArry = ["Ekle","İptal","",""];
                    var btnColorArry = ["btn-primary addCategories","btn-secondary","btn-secondary",""];
                    var btnCancel = "modalbttn2";
                    modalPlacement(btnArry,btnColorArry,btnCancel,modalNameText,modalBdy);
        });

        $("#newModal .modal-footer").on("click", ".addCategories", function(){  
          $('#errPlace').html('');
          var adi = $('#adi').val();
          var maliyet = $('#maliyet').val();
          var ktgrid = $('#ktgrid').val();
          postData.push({name: "adi", value: adi});
          postData.push({name: "kategori", value: ktgrid});
          postData.push({name: "maliyet", value: maliyet});
          postData.push({name: "type", value: 'ekle'});
          postUrl = 'qrry/hammadde.php';
          SendPostJson(postData,postUrl,addNewSplierSccs,addNewSplierErr);
         });
      });
    </script>
    <!-- /Datatables -->

  
  </body>
</html>