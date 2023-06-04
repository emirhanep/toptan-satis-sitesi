<?php $menuPlace= "urunler"; include 'header.php';


?>



<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-title-wrap">
				<div class="page-title-inner">
					<div class="row">
						<div class="col-md-4">
							<div class="bread"><a href="#">Tüm Ürünler</a></div>
							<div class="bigtitle">Ürünler</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12"><!--Main content-->
			<div class="title-bg">
				<div class="title">Çok Satan Ürünler</div>
				<!-- <div class="title-nav">
					<a href="category.htm"><i class="fa fa-th-large"></i>grid</a>
					<a href="category-list.htm"><i class="fa fa-bars"></i>List</a>
				</div> -->
			</div>
			<div class="row prdct"><!--Products-->
			<?php
			echo '<div class="col-md-4">
			<div class="productwrap">
				<div class="pr-img">
					<a style="cursor:unset"><img src="productImages/makeYourOwn.jpg" alt="" class="img-responsive"></a>
					<div class="pricetag blue" style="top:66%"><div class="inner" style="font-size:14px;">0.00 TL</div></div>
				</div>
				<span class="smalltitle"><a>Kendin Yap</a></span>
				<span class="smalldesc kendinYap" data-id="0"><i class="fa fa-plus-circle"></i> Sepete Ekle</span>
			</div>
			</div>';
			
			$kistas = "`drm` =  '1'";
			$queryBilgiAl = "SELECT * FROM `urunler` WHERE $kistas";
			$sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
			while($row = mysqli_fetch_array($sonucBilgiAl)) { 
						$mxLn = 20;
						
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
			$sonucBilgiAl->close();
			?>
				
			</div><!--Products-->
			

		</div>
		
	</div>
	<div class="spacer"></div>
</div>

<?php include 'footer.php' ?>