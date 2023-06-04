<?php ?> 
<div class="f-widget featpro">
		<div class="container">
			<div class="title-widget-bg">
				<div class="title-widget">Ürünler</div>
				<div class="carousel-nav">
					<a class="prev"></a>
					<a class="next"></a>
				</div>
			</div>
			<div id="product-carousel" class="owl-carousel owl-theme">
				<?php
				echo '<div class="item">
				<div class="productwrap">
					<div class="pr-img">
						
						<a style="cursor:unset"><img src="productImages/makeYourOwn.jpg" alt="" class="img-responsive"></a>
						<div class="pricetag blue" style="top:66%"><div class="inner" style="font-size:14px;"><span>0.00 TL</span></div></div>
					</div>
						<span class="smalltitle"><a>Kendin Yap</a></span>
						<span class="smalldesc kendinYap" data-id="0"><i class="fa fa-plus-circle"></i> Sepete Ekle</span>
				</div>
			</div>';
					$mxLn = 20; 
					$kistas = "`drm` =  '1' ORDER BY RAND() LIMIT 7";

					$queryBilgiAl = "SELECT * FROM `urunler` WHERE $kistas"; 
						$sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
						$response = array();
						while($row = mysqli_fetch_array($sonucBilgiAl)) { 
							if(strlen($row["adi"]) > $mxLn) { $row["adi"]= substr($row["adi"],0,$mxLn); }
							echo '<div class="item">
						<div class="productwrap">
							<div class="pr-img">
								
								<a style="cursor:unset"><img src="productImages/'.$row["resim"].'" alt="" class="img-responsive"></a>
								<div class="pricetag blue" style="top:66%"><div class="inner" style="font-size:14px;"><span>'.$row["maliyet"].' TL</span></div></div>
							</div>
								<span class="smalltitle"><a>'.$row["adi"].'</a></span>
								<span class="smalldesc urnAktif" data-id="'.$row["id"].'"><i class="fa fa-plus-circle"></i> Sepete Ekle</span>
						</div>
					</div>';

						}

					
					

				?>
				
				
				
				
			</div>
		</div>
	</div>