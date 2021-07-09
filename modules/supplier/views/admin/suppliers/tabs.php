<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked customer-tabs" role="tablist">
  <?php

 // Junaid code here
  if(isset($client) && $client->is_supplier == 1){
    $customer_tabs = $supplier_tabs;
    $mysupplier = 8;
  }else{
    $mysupplier = 20;
  }

 $countsupplier = 1;


  foreach(filter_client_visible_tabs($customer_tabs) as $key => $tab){

    if($countsupplier <= $mysupplier){
    ?>
    <li class="<?php if($key == 'profile'){echo 'active ';} ?>customer_tab_<?php echo $key; ?>">
      <a data-group="<?php echo $key; ?>" href="<?php echo admin_url('supplier/client/'.$client->userid.'?group='.$key); ?>">
        <?php if(!empty($tab['icon'])){ ?>
            <i class="<?php echo $tab['icon']; ?> menu-icon" aria-hidden="true"></i>
        <?php } ?>
        <?php echo $tab['name'] ; ?>
      </a>
    </li>
    <?php 
    }
    
    $countsupplier++;
} ?>

</ul>
