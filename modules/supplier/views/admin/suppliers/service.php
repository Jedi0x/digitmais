<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_open_multipart('admin/supplier/manage_services/'.$clientid, array('id' => 'offerProductsForm', 'class' => '_transaction_form')); ?>
<div class="row">
    <div class="col-md-6">
        <?php if (isset($product)) {
            echo form_hidden('id', $product->id);
        } ?>
        <div class="checkbox checkbox-primary">
            <input type="checkbox" name="is_publish" id="is_publish" <?php if(isset($product)){if($product->is_publish == 1){echo 'checked';} } else {echo 'checked';} ?>>
            <label for="is_publish"><?php echo _l('publish_service'); ?></label>
        </div>

        <div class="checkbox checkbox-primary">
            <input type="checkbox" name="is_featured" id="is_featured" <?php if(isset($product)){if($product->is_featured == 1){echo 'checked';} }  ?>>
            <label for="is_featured"><?php echo _l('featured_service'); ?></label>
        </div>
        <?php $value = (isset($product) ? $product->description : ''); ?>
        <?php echo render_input('name', 'name', $value, 'text', [], [], '', 'ays-ignore'); ?>

        <?php $value = (isset($product) ? $product->long_description : ''); ?>
        <?php echo render_textarea('long_description', _l('long_description') . ' <i class="fa fa-question-circle" data-toggle="tooltip" data-title="' . _l('long_description_hint') . '"></i>', $value, [], [], '', 'ays-ignore'); ?>
    </div>

    <div class="col-md-6">

        <?php $value = (isset($product) ? $product->offer_time : ''); ?>
        <?php echo render_input('offer_time', 'offer_video_time',$value, 'number'); ?>
        <?php $value = (isset($product) ? $product->offer_video_number : ''); ?>
        <?php echo render_input('offer_video_number', 'offer_video_number',$value, 'number'); ?>
        <?php $value = (isset($product) ? $product->rate : ''); ?>
        <?php echo render_input('price', 'price', $value, 'number', [], [], '', 'ays-ignore'); ?>
        <?php
        $s_attrs = array('data-show-subtext' => true);
        foreach ($currencies as $currency) {
          if ($currency['isdefault'] == 1) {
           $s_attrs['data-base'] = $currency['id'];
       }
       if ($currency['isdefault'] == 1) {
       $selected = $currency['id'];
   }
}
?>
<?php echo render_select('currency', $currencies, array('id', 'name', 'symbol'), 'currency', $selected,  $s_attrs, [], '', 'ays-ignore'); ?>

<?php

if(isset($product)){
  $required = '';
}else{
  $required = 'required';
}
?>

<?php $value = (isset($product) ? $product->offer_embed_link : ''); ?>
<?php echo render_input('offer_embed_link', 'offer_embed_link',$value); ?>

<div class="row attachments" style="margin-bottom: 15px;">
    <div class="attachment">
       <div class="col-md-12">
          <div class="form-group attachment">
             <label for="attachment" class="control-label"><?php echo _l('add_task_attachments'); ?></label>
             <div class="input-group">
               <input type="file" id="attachments"  <?php echo $required; ?>  extension="<?php echo str_replace('.','',get_option('allowed_files')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachments[]">
               <span class="input-group-btn">
                  <button class="btn btn-success add_more_attachments p8" type="button"><i class="fa fa-plus"></i></button>
              </span>
          </div>
      </div>
  </div>
</div>
</div>

<?php

if(isset($product)){ 
   $attachments = get_product_attachemnt($product->id);
   $size =  count($attachments);
   foreach ($attachments as $key => $attachment) { ?>

      <div class="row" style="margin-bottom: 15px;">
         <div class="col-md-10">
            <i class="mime mime-image"></i> <a href="<?php echo site_url('download/file/service/'.$attachment['attachment']); ?>"><?php echo $attachment['attachment']; ?></a>
        </div>
        <?php if($size > 1){ ?>
         <div class="col-md-2 text-right">
            <a href="<?php echo admin_url('supplier/delete_service_attachment/'.$attachment['attachment'].'/'.$attachment['attachment']); ?>" class="text-danger _delete"><i class="fa fa fa-times"></i></a>
        </div>
    <?php } ?>
    </div><?php
}

}

?>

</div>
</div>

   <div class="btn-bottom-toolbar text-right">
      <button type="submit" class="btn btn-info" data-loading-text="<?php echo _l('wait_text'); ?>">
         <?php echo _l('save'); ?>
     </button>
 </div>



<?php echo form_close(); ?>