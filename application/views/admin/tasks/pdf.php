<?php

defined('BASEPATH') or exit('No direct script access allowed');

if(strlen($task->description) > 60){
	$description = substr($task->description,0,60).' ...';
}else{
	$description = $task->description;
}


$customFieldsData = array();
$custom_fields = get_table_custom_fields('tasks');
$CI = & get_instance();
foreach ($custom_fields as $key => $feild) {
    $CI->db->select('*');
    $CI->db->where(db_prefix() . 'customfieldsvalues.relid',$task->id);
    $CI->db->where('fieldid',$feild['id']);
    $feild_data = $CI->db->get(db_prefix() . 'customfieldsvalues')->row();
    if(!empty($feild_data)){
    	$customFieldsData[$feild['slug']]['slug'] = $feild['slug'];
    	$customFieldsData[$feild['slug']]['name'] = $feild['name'];
    	$customFieldsData[$feild['slug']]['val'] = $feild_data->value;
    }else{
    	$customFieldsData[$feild['slug']]['slug'] = $feild['slug'];
    	$customFieldsData[$feild['slug']]['name'] = $feild['name'];
    	$customFieldsData[$feild['slug']]['val'] = '';
    }

}


$barcode = base_url('uploads/barcode/voucherbarcode.png');
$qr_code_path = base_url('uploads/taskpdf/digitmaisqr.png');

?>


<table border="2" width="100%" style="padding-top:5px;">

	<tr>
		<td width="60%" >
			<table style="padding-bottom:40px;">
				<tr width="100%">
					<td width="50%"><p><b>Customer</b><br><?php echo format_customer_info_updated($task, 'invoice', 'billing'); ?></p></td>
					<td width="50%"><p><b>Subjet</b><br><?php echo $task->name; ?></p></td>
				</tr>
			</table>
		</td>
		<td width="40%" rowspan="3" colspan="2">
			<?php echo pdf_logo_url_updated(200); ?> <br> <?php echo format_organization_info(); ?>
		</td>
	</tr>

	
</table>




