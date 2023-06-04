<?php $menuPlace= "AnaSyf"; include 'header.php' ?>
					
	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-title-wrap">
					<div class="page-title-inner">
					<div class="row">
						<div class="col-md-4">
							<div class="bread"><a href="#">Home</a> &rsaquo; Orders</div>
							<div class="bigtitle">Orders</div>
						</div>
						
					</div>
					</div>
				</div>
			</div>
		</div>
		<div id="title-bg">
			<div class="title">Orders</div>
		</div>
		
		<div class="table-responsive">
			<table class="table table-bordered chart">
				<thead>
					<tr>
						<th>Order ID</th>
						<th>Price</th>
						<th>Status</th>
						
					</tr>
				</thead>
				<tbody> 
					<?php
					
					$queryBilgiAl = "SELECT DISTINCT `alverno` FROM `sepet`";
					$sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
					while($row = mysqli_fetch_array($sonucBilgiAl)) { 
						$status = "Ödeme Alındı";
						$alverno = $row["alverno"];
						$kistas = "`alverno` =  '$alverno'";
						$sptTplm = getSubTotal("sepet",$kistas,"tplmbdel");
						$bilgAry = bilgiGetirArray("sepet",$kistas);
						if($bilgAry["drm"] == 2) { $status = "Hazırlanıyor"; }
						if($bilgAry["drm"] == 3) { $status = "Kargoda"; }
						if($bilgAry["drm"] == 4) { $status = "Teslim Edildi"; }
						echo '<tr>
						<td>'.$row["alverno"].'</td>
						<td>'.$sptTplm.'</td>
						<td>'.$status.'</td>
						
					</tr>';


					}
					$sonucBilgiAl->close();

					?>
					
				</tbody>
			</table>
		</div>
		<div class="spacer"></div>
	</div>
	
	<?php include 'footer.php' ?>