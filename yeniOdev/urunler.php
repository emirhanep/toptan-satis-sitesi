<?php ?>
		<div class="title-bg">
					<div class="title">En Çok Ziyaret Edilen Ürünler</div>
				</div>
				<div class="row prdct"><!--Products-->
				<?php

					echo '<div class="col-md-4">
					<div class="productwrap">
						<div class="pr-img">
							<a style="cursor:unset"><img src="productImages/makeYourOwn.jpg" alt="" class="img-responsive" width="450" height="337"></a>
							<div class="pricetag blue" style="top:66%"><div class="inner" style="font-size:14px;">0.00 TL</div></div>
						</div>
						<span class="smalltitle"><a>Kendin Yap</a></span>
						<span class="smalldesc kendinYap" data-id="0"><i class="fa fa-plus-circle"></i> Sepete Ekle</span>
					</div>
					</div>';

					$kistas = "`drm` =  '1' ORDER BY RAND() LIMIT 6";
					$queryBilgiAl = "SELECT * FROM `urunler` WHERE $kistas"; 
					$sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
					$response = array();
					while($row = mysqli_fetch_array($sonucBilgiAl)) { 
						if(strlen($row["adi"]) > $mxLn) { $row["adi"]= substr($row["adi"],0,$mxLn); }
						echo '<div class="col-md-4">
						<div class="productwrap">
							<div class="pr-img">
								<a style="cursor:unset"><img src="productImages/'.$row["resim"].'" alt="" class="img-responsive"></a>
								<div class="pricetag blue" style="top:66%"><div class="inner" style="font-size:14px;">'.$row["maliyet"].' TL</div></div>
							</div>
							<span class="smalltitle"><a>'.$row["adi"].'</a></span>
							<span class="smalldesc urnAktif" data-id="'.$row["id"].'"><i class="fa fa-plus-circle"></i> Sepete Ekle</span>
						</div>
						</div>';

					}

					


				?>
					
				</div><!--Products-->