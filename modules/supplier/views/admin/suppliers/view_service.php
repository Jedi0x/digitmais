<style type="text/css">
    .item.active{
            justify-content: center;
    display: flex;
    }
    .carousel-control.left,.right.carousel-control{
        background-image: none!important; 
    }
    .glyphicon-chevron-left,.glyphicon-chevron-right{
        color: #000;
    }
    .w-100{
        width: 100%;
    }
     table.custom_pd th{
        padding: 0px 15px; 
    }

    iframe{
	height: 160px !important;
	width: 220px !important;
}
</style>


	<div class="modal-content">
		<div class="modal-header">
			<button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">
				<span><?=$product->description?></span>
			</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<?php  $attachments = get_product_attachemnt($product->id); ?>
					<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
							<?php 

							$iframe_active = false;

							if(!empty($product->offer_embed_link)){ 

								$iframe_active = true; ?>

								<div class="item active">
									<?=htmlspecialchars_decode($product->offer_embed_link)?>
								</div>

							<?php }

							foreach ($attachments as $k => $v) { 

								if($iframe_active){
									$active = '';
								}else{
									$active = (($k == 0)?'active':'');
								}
								?>

								<div class="item <?php echo $active; ?>">
									<img class="d-block w-100" src="<?=base_url(SERVICE_IMAGE_UPLOAD.$v['attachment'])?>" style="width:220px;height: 160px;">
								</div>

								<?php
								
							}

							?>
							
							
						</div>
						<!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
					</div>

					
					<hr/>
					<table class="text-center w-100 custom_pd" >
						<tr>
							<th class="bold"><?=_l('name')?></th>
							<th><?= $product->description ?></th>
						</tr>
						<tr>
							<th class="bold"><?=_l('long_description')?></th>
							<th><?= $product->long_description ?></th>
						</tr>
						
						<tr>
							<th class="bold"><?=_l('offer_video_time')?></th>
							<th><?= $product->offer_time ?></th>
						</tr>
						<tr>
							<th class="bold"><?=_l('offer_video_number')?></th>
							<th><?= $product->offer_video_number ?></th>
						</tr>
						<tr>
							<th class="bold"><?=_l('price')?></th>
							<th><?= "$ ".app_format_number($product->rate); ?></th>
						</tr>

						<?php 

						if ($product->is_publish == 1) {
							$publish = '<span class="badge bg-success">'._l('published').'</span>';
						}
						else{
							$publish = '<span class="badge bg-warning">'._l('not_publish').'</span>';
						}

						if ($product->is_featured == 1) {
							$featured = '<span class="badge bg-success">'._l('featured').'</span>';
						}
						else{
							$featured = '<span class="badge bg-warning">'._l('not_featured').'</span>';
						}


						?>
						<tr>
							<th class="bold"><?=_l('publish_service')?></th>
							<th><?= $publish ?></th>
						</tr>

						<tr>
							<th class="bold"><?=_l('featured_service')?></th>
							<th><?= $featured ?></th>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
		</div>
	</div>
