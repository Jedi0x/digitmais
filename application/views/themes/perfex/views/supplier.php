<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-12 section-client-dashboard">
		<h3 id="greeting" class="no-mtop"></h3>
		<?php if(has_contact_permission('projects')) { ?>
			<div class="panel_s">
				<div class="panel-body">
					<h3 class="text-success projects-summary-heading no-mtop mbot15"><?php echo _l('supplier_summary'); ?></h3>
					<div class="row">
						<?php

						$where = array('clientid'=>get_client_user_id()); ?>

						<div class="col-md-4 list-status projects-status">
							<a href="<?php echo base_url('supplier/product_services/orders'); ?>" class="">
								<h3 class="bold"><?php echo $orders;?></h3>
								<span style="color:red">Order
							</a>
						</div>

						<div class="col-md-4 list-status projects-status">
							<a href="<?php echo base_url('supplier/product_services'); ?>" class="">
								<h3 class="bold"><?php echo $services;?></h3>
								<span style="color:green">Services
							</a>
						</div>


						<div class="col-md-4 list-status projects-status">
							<a href="#" class="">
								<h3 class="bold"><?php echo $credits_available;?></h3>
								<span style="color:blue">Credits Available
							</a>
						</div>

								
						
					</div>
				</div>
			</div>
		<?php } ?>
		<?php hooks()->do_action('client_area_after_project_overview'); ?>
		<div class="panel_s">
			<?php
			if(has_contact_permission('invoices')){ ?>
				<div class="panel-body">
					
					<hr />
					
					<div class="row">
						<div class="col-md-12">
							<div class="relative" style="max-height:400px;">
								<canvas id="supplier-home-chart" height="400" class="animated fadeIn"></canvas>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<script>
		var greetDate = new Date();
		var hrsGreet = greetDate.getHours();

		var greet;
		if (hrsGreet < 12)
			greet = "<?php echo _l('good_morning'); ?>";
		else if (hrsGreet >= 12 && hrsGreet <= 17)
			greet = "<?php echo _l('good_afternoon'); ?>";
		else if (hrsGreet >= 17 && hrsGreet <= 24)
			greet = "<?php echo _l('good_evening'); ?>";

		if(greet) {
			document.getElementById('greeting').innerHTML =
			'<b>' + greet + ' <?php echo $contact->firstname; ?>!</b>';
		}
	</script>
