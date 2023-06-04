
<div id="kndnYpLyr" style="position:fixed; width:100%; height:100%; background:black; opacity: 0.5; top:0; left:0; z-index:9; display:none;"></div>
<div id="kndnYpLyrDty" style="position:fixed; width:50%; height:auto; min-height:300px; padding-bottom:30px; left:25%; top:3%; background:white;  z-index:10; display:none;">
	<h4 style="padding-left:15px;padding-top:20px;">Kendin Yap -- <span id="kndnYapHeader"></span></h4>
	<div id="KndnYpKapa" style="float:right; padding-right:30px; font-weight: bold; margin-top: -40px; font-size: 21px; font-weight: bold; cursor:pointer;">X</div>
	<div id="errPlace" style="width:100%; color:#e74a3b; text-align:center; margin-bottom:20px;"></div>
	
			<form class="form-inline ktgrScm" style="margin-left:15px;">
		<div class="form-group mb-2">
			<label for="staticEmail2" class="sr-only">Kategori</label>
			<select class="form-select" id="kndnSlct" aria-label="Default select example">
			<option selected>Seçiniz</option>
			<?php
				$kistas = "`drm` =  '1'";
				$queryBilgiAl = "SELECT * FROM `kategoriler` WHERE $kistas";
				$sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
				while($row = mysqli_fetch_array($sonucBilgiAl)) { 
					echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
				 }
			?>
			
			</select>
		</div>
		<div class="form-group mx-sm-3 mb-2">
			<label for="inputPassword2" class="sr-only">Miktar</label>
			<input type="number" id="kndnAdet" class="form-control-plaintext"  placeholder="Adet">
			<input type="hidden" id="kndnKtgr">
		</div>
		<button type="button" class="btn btn-primary mb-2 addKnypKtgr">Ekle</button>
		</form>
		<div id="kndnYapTeklif" class="col-md-12 text-success text-center" style="margin-top:15px; font-size:20px"></div>
		<div id="kndnYpHmmdeAln" style="margin-top:15px;"></div>
</div>



<div class="f-widget"><!--footer Widget-->
			<div class="container">
				<div class="row">
					
							
									
							</div><!--footer newsletter widget-->
							<div class="col-md-12"><!--footer contact widget-->
								<div class="title-widget-bg">
									<div class="title-widget-cursive">Baskı Corner</div>
								</div>
								<ul class="contact-widget">
									<li class="fphone">+387 123 456, +387 123 456 <br> +387 123 456</li>
									<li class="fmobile">+387-123-456-1<br>+387-123-456-2</li>
									<li class="fmail lastone">baskicorner@gmail.com<br>baskicorner@icloud.com</li>
								</ul>
							</div><!--footer contact widget-->
						</div>
						<div class="spacer"></div>
					</div>
				
								<div class="clearfix"></div>
							</div><!--footer Share-->
						</div>
					</div>
				</div><!--footer-->
				<div id="genMessageArea" style="position:fixed; z-index: 100; top:115px; right:15px; display:none;"><div id="genMessage" class="col-md-6 col-sm-12 text-center" style="background: #39b3ca; border-radius: 2%; width: auto; padding: 14px 100px; box-shadow: 2px 3px #888888; font-size: 16px; color: white;">Hooop!</div></div>


				<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
				<!-- Include all compiled plugins (below), or include individual files as needed -->
				<script src="bootstrap\js\bootstrap.min.js"></script>

				<!-- map -->
				<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
				<script type="text/javascript" src="js\jquery.ui.map.js"></script>
				<script type="text/javascript" src="js\demo.js"></script>

				<!-- owl carousel -->
				<script src="js\owl.carousel.min.js"></script>

				<!-- rating -->
				<script src="js\rate\jquery.raty.js"></script>
				<script src="js\labs.js" type="text/javascript"></script>

				<!-- Add mousewheel plugin (this is optional) -->
				<script type="text/javascript" src="js\product\lib\jquery.mousewheel-3.0.6.pack.js"></script>

				<!-- fancybox -->
				<script type="text/javascript" src="js\product\jquery.fancybox.js?v=2.1.5"></script>

				<!-- custom js -->
				<script src="js/shop.js"></script>
				<script src="js/mainfunctions.js"></script>
				<script src="js/register.js"></script>
				<script src="js/kendinYap.js"></script>
				
			</div>
		</body>
		</html>