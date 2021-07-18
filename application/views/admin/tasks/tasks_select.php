<div class="task-drop form-group" id="task_wrapper">
	<label for="task" class="control-label"><span class="task_label">Task</span></label>
	<div id="task_select">
		<select name="task" required id="task" class="ajax-sesarch" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
			<?php 
			if(empty($tasks)){
				echo '<option value="" selected>No Tasks Selected</option>';
			}else{
				echo '<option value="" selected>Please Select</option>';
				
					echo '<option value="select_all">Select All</option>';
				
				foreach ($tasks as $key => $task) {
				 echo '<option value="'.$task['id'].'">'.$task['name'].'</option>';
				}
			}
			 ?>
		</select>
	</div>
</div>

<script>
	init_datepicker();
	init_color_pickers();
	init_selectpicker();
	task_rel_select();
</script>