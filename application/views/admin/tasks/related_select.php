<div class="task-drop form-group" id="task_wrapper">
	<label for="task" class="control-label"><span class="task_label"><?=_l($rel_type)?></span></label>

		<select name="rel_id" required id="rel_id" class="ajax-sesarch" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
			<?php 
			if(empty($select_options)){
				echo '<option value="" selected>Please Select</option>';
			}else{
				echo '<option value="" selected>Please Select</option>';
				echo '<option value="select_all">Select All</option>';
				foreach ($select_options as $key => $select_option) {
				 echo '<option value="'.$select_option['id'].'">'.$select_option['name'].'</option>';
				}
			}
			 ?>
		</select>
</div>

<script>
	init_selectpicker();
</script>