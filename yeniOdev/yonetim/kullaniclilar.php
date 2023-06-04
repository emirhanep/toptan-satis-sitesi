<?php include("header.php"); ?>

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
                <h3>Kullanıcı <small>İşlemleri</small></h3>
              </div>

              
            </div>

            <div class="clearfix"></div>

            <div class="row">
              

              

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Kullanıcı <small>Listesi</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                        <th class="text-center align-middle">No</th>
                          <th class="text-center align-middle">Adi</th>
                          <th class="text-center align-middle">Eposta </th>
                          <th class="text-center align-middle">Telefon</th>
                          <th class="text-center align-middle">Kayıt Tarihi</th>
                          <th class="text-center align-middle">Kayıt Ip</th>
                          <th class="text-center align-middle">Adres Bilgisi</th>
                          <th class="text-center align-middle">Alış Verişleri</th>
                          
                         
                          
                        </tr>
                      </thead>
                      <tbody>
                       <?php 

                       function getAdresBilgi($id){
                            include("ekler/baglan.php");
                            $sonuc = NULL;
                            $kistas = "`kullanici` = '$id'";
                            $queryBilgiAl = "SELECT * FROM `adres` WHERE $kistas";
                            $sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
                            $satirBilgiAl = $sonucBilgiAl->fetch_array(MYSQLI_ASSOC);
                            $sonucBilgiAl->close();
                            $sonuc = $satirBilgiAl["adres"]." ".$satirBilgiAl["postakodu"]." ".$satirBilgiAl["sehir"]."/".$satirBilgiAl["ulke"];
                            return($sonuc);
                       }
                        $kistas = "`yetki` = '0'";
                        $queryBilgiAl = "SELECT * FROM `kullanici` WHERE $kistas"; 
                        $sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl); 
                        while($row = mysqli_fetch_array($sonucBilgiAl)) { 
                            $kid = $row["id"];
                            echo '<tr>
                            <td class="text-center align-middle">'.$row["id"].'</td>
                            <td class="text-center align-middle">'.$row["isim"].' '.$row["soyad"].'</td>
                            <td class="text-center align-middle">'.$row["mail"].'</td>
                            <td class="text-center align-middle">'.$row["tel"].'</td>
                            <td class="text-center align-middle">'.$row["tarih"].'</td>
                            <td class="text-center align-middle">'.$row["ip"].'</td>
                            <td class="text-center align-middle">'.getAdresBilgi($row["id"]).'</td>
                            <td class="text-center align-middle"><a class="btn btn-primary btn-xs" href="alisverisler.php?kid='.$kid.'" role="button">Alışverişler</a></td>
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
       


      $(document).ready(function() {
       
      });
    </script>
    <!-- /Datatables -->

  
  </body>
</html>