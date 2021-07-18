<?php

defined('BASEPATH') or exit('No direct script access allowed');

$dimensions = $pdf->getPageDimensions();


foreach ($task_ids as $key => $task) {

	$task = get_task_data($task);

	if(strlen($task->description) > 190){
		$description = substr($task->description,0,190).' ...';
	}else{
		$description = $task->description;
	}



	$code = $task->id.$task->project_data->client_data->userid.date('H:id/m/Y');

	$barcodename = $task->id.'-'.date('ymdhis');
	generate_barcode($code,$barcodename);


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


	$barcode = base_url('uploads/barcode/'.$barcodename.'.png');
	$qr_code_path = base_url('uploads/taskpdf/digitmaisqr.png');


	if($type == 'admin'){

	$section_one ='<style>p{ font-size:12px; }</style>';
	$section_one .= '<table border="2" width="100%" style="padding-top:5px;" >

		<tr>
			<td width="60%" >
				<table style="padding-bottom:40px;">
					<tr>
						<td><p><b>'._l('client').'</b><br>'.format_customer_info_updated($task, 'invoice', 'billing').'</p></td>
						<td><p><b>'._l('project_discussion_subject').'</b><br>'.$task->name.'</p></td>
					</tr>
				</table>
			</td>
			<td width="40%" rowspan="2" colspan="2">
				'.pdf_logo_url_updated(200).'<br>'.format_organization_info().'
			</td>
		</tr>

		<tr>
			<td>
				<table>
					<tr>
						<td>
							<table style="padding-bottom:20px;">
								<tr>
									<td><p><b>'.$customFieldsData['tasks_destinatario']['name'].'</b><br>'.$customFieldsData['tasks_destinatario']['val'].'</p></td>
									<td><p><b>'.$customFieldsData['tasks_tel_contato_da_entrega']['name'].'</b><br> '.$customFieldsData['tasks_tel_contato_da_entrega']['val'].'</p></td>
								</tr>
								<tr>
									<td colspan="2"><p><b>'.$customFieldsData['tasks_local_de_carga']['name'].'</b><br>'.$customFieldsData['tasks_local_de_carga']['val'].'</p></td>
								</tr>
							</table>
						</td>	
					</tr>
				</table>
			</td>
		</tr>



		<tr>
			<td>
				<table style="padding-bottom:15px;">
					<tr>
						<td><p><b>'.$customFieldsData['tasks_local_de_carga_contato']['name'].'</b><br>'.$customFieldsData['tasks_local_de_carga_contato']['val'].'</p></td>
						<td><p><b>'.$customFieldsData['tasks_localidade_carga']['name'].'</b><br>'.$customFieldsData['tasks_localidade_carga']['val'].'</p></td>
					</tr>
				</table>
			</td>
			<td colspan="2">
				<p><b>'.$customFieldsData['tasks_previsao_entrega']['name'].'</b><br>'.$customFieldsData['tasks_previsao_entrega']['val'].'</p>
			</td>
		</tr>


		<tr>
			<td>
				<table style="padding-bottom:15px;">
					<tr>
						<td><p><b>'.$customFieldsData['tasks_codpostal_carga']['name'].'</b><br>'.$customFieldsData['tasks_codpostal_carga']['val'].'</p></td>
						<td><p><b>'.$customFieldsData['tasks_tel_contato_carga']['name'].'</b><br> '.$customFieldsData['tasks_tel_contato_carga']['val'].'</p></td>
					</tr>
				</table>
			</td>

			<td colspan="2">
				<table>
					<tr style="padding-top:5px;">
						<td><p style="font-size:12px;"><b>'.$customFieldsData['tasks_volumes']['name'].'</b><br>'.$customFieldsData['tasks_volumes']['val'].'</p></td>
						<td><p style="font-size:12px;"><b>'.$customFieldsData['tasks_kms']['name'].'</b><br>'.$customFieldsData['tasks_kms']['val'].'</p></td>
						<td><p style="font-size:12px;"><b>'.$customFieldsData['tasks_peso']['name'].'</b><br>'.$customFieldsData['tasks_peso']['val'].'</p></td>
					</tr>
				</table>
			</td>
		</tr>
		

	</table>
	<table width="100%" style="padding-top:5px; border: 2px solid #000">
		<tr>
			<td colspan="2" width="60%">
				<table style="padding-bottom:40px; border-right:none;">
					<tr>
						<td><p><b>'._l('task_add_edit_description').'</b><br>'.$description.'</p></td>
					</tr>
				</table>
			</td>
			<td colspan="2" width="40%">
				<table style="border: none;">
					<tr>
						<td align="left"><p style="font-size:12px;"><b>'.$customFieldsData['tasks_recebido_numerario']['name'].'</b><br>'.$customFieldsData['tasks_recebido_numerario']['val'].'</p></td>
						<td><p style="font-size:12px;"><b>'.$customFieldsData['tasks_recebido_tpa_2']['name'].'</b><br>'.$customFieldsData['tasks_recebido_tpa_2']['val'].'</p></td>
						<td><p style="font-size:12px;"><b>'.$customFieldsData['tasks_recebido_tpa']['name'].'</b><br>'.$customFieldsData['tasks_recebido_tpa']['val'].'</p></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table border="2" width="100%" style="padding-top:5px;">

		<tr>
			<td width="34%" style=" font-size: 10px; height:100px;"><br><br><br><br><br><br><br><br>______/______/______ ______:______  Assinatura Transport</td>
			<td width="33%" style="font-size: 10px; height:100px;"><br><br><br><br><br><br><br><br>______/______/______ ______:______  Assinatura Cliente</td>
			<td width="33%"><p><b>'.$customFieldsData['tasks_observacao']['name'].'</b><br>'.$customFieldsData['tasks_observacao']['val'].'</p></td>
		</tr>
	</table>
	<table width="100%">

	<tr>
		<td width="50%" align="left" style="font-size: 10px; float: left;">Processado por computador - Deliberação 813/2020</td>
		<td width="50%" align="right" style="font-size: 10px; float:right;">Processado por computador - Deliberação 813/2020</td>
	</tr>

	</table> ';

	$x     = $pdf->GetX();
	$start = $pdf->GetY();
	$pdf->writeHTML($section_one, false, false, false, false, '');

	$height = $pdf->GetY() - $start + 8;


	$pdf->StartTransform();
	// Rotate 20 degrees counter-clockwise centered by (70,110) which is the lower left corner of the rectangle
	$pdf->Rotate(90,5,$height);
	$pdf->Text(5,$height, 'Software de Gestão e Inovação - www.digitmais.com');
	// Stop Transformation
	$pdf->StopTransform();


	$pdf->Ln(hooks()->apply_filters('pdf_info_and_table_separator', 6));




	$spacer = '-----------------------------------------------------------------------------------------------------------------------------------------------------------------';

	$pdf->writeHTML($spacer, false, false, false, false, '');

	$pdf->Ln(hooks()->apply_filters('pdf_info_and_table_separator', 6));



	$section_two ='<style>p{ font-size:12px; }</style>';




	$section_two .='

	<table width="100%" style="padding-top:5px;padding-left: 15px; padding-right: 15px" >
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td width="25%" align="left"><img src="'.$qr_code_path.'" width="90px;"></td>
						<td width="50%" align="center"><p><br>'.pdf_logo_url_updated(250,'style="vertical-align: middle;text-align:center;"').'</p></td>
						<td width="25%" align="right"><img src="'.$qr_code_path.'" width="90px;"></td>
					</tr>
				</table>

				<table width="100%">
					<tr>
						<td style="background-color: black; color:white; vertical-align:middle; text-align:center; height:30px;width: 100%;line-height: 30px">SMART CODE</td>
					</tr>
				</table>

				<table style="padding-bottom:10px; border-bottom:2px solid #000;width: 100%;padding-left: 0px;padding-right: 0px;">
					<tr>
						<td><p><b>'.$customFieldsData['tasks_local_de_carga_contato']['name'].'</b><br>'.$customFieldsData['tasks_local_de_carga_contato']['val'].'</p></td>
						<td align="right">
						<p><b>'.$customFieldsData['tasks_tel_contato_carga']['name'].'</b><br>'.$customFieldsData['tasks_tel_contato_carga']['val'].'</p>
						</td>
					</tr>
					<tr>
						<td width="50%" align="right"></td>
						<td width="50%" align="right"><p><b>'._l('project_discussion_subject').'</b><br>'.$task->name.'</p></td>
					</tr>
				</table>

				<table style="padding-bottom:40px; border-bottom:2px solid #000;width: 100%;padding-left: 0px;padding-right: 0px;">
					<tr>
						<td><p><b>'.$customFieldsData['tasks_destinatario']['name'].'</b><br>'.$customFieldsData['tasks_destinatario']['val'].'</p></td>
						<td  align="right"><p><b>'.$customFieldsData['tasks_tel_contato_da_entrega']['name'].'</b><br>'.$customFieldsData['tasks_tel_contato_da_entrega']['val'].'</p></td>
					</tr>
				</table>

				<table style="padding-top:60px;width: 100%;padding-left: 0px;padding-right: 0px;">
					<tr>
						<td><img src="'.$barcode.'" ></td>
					</tr>
				</table>

				<table width="100%">
					<tr>
						<td style="background-color: #000; color:white; vertical-align:middle; text-align:center; height:20px;line-height: 20px;">24H</td>
					</tr>
				</table>

				<table width="100%">
					<tr>
						<td style="text-align:center; border-bottom:2px solid #000;"><b style="color:black" class="company-name-formatted">' . get_option('invoice_company_name') . '</b></td>
					</tr>
				</table>
				
			</td>


			<td>
				<table width="100%">
					<tr>
						<td width="25%" align="left"><img src="'.$qr_code_path.'" width="90px;"></td>
						<td width="50%" align="center"><p><br>'.pdf_logo_url_updated(250,'style="vertical-align: middle;text-align:center;"').'</p></td>
						<td width="25%" align="right"><img src="'.$qr_code_path.'" width="90px;"></td>
					</tr>
					
				</table>

				<table width="100%">
					<tr>
						<td style="background-color: black; color:white; vertical-align:middle; text-align:center; height:30px;width: 100%;line-height: 30px">SMART CODE</td>
					</tr>
				</table>

				<table style="padding-bottom:10px; border-bottom:2px solid #000; width: 100%;padding-left: 0px;padding-right: 0px;">
					<tr>
						<td><p><b>'.$customFieldsData['tasks_local_de_carga_contato']['name'].'</b><br>'.$customFieldsData['tasks_local_de_carga_contato']['val'].'</p></td>
						<td align="right">
						<p><b>'.$customFieldsData['tasks_tel_contato_carga']['name'].'</b><br>'.$customFieldsData['tasks_tel_contato_carga']['val'].'</p>
						</td>
					</tr>

					<tr>
						<td width="50%" align="right"></td>
						<td width="50%" align="right">
						<p><b>'._l('project_discussion_subject').'</b><br>'.$task->name.'</p></td>
					</tr>
				</table>

				<table style="padding-bottom:40px; border-bottom:2px solid #000;width: 100%;padding-left: 0px;padding-right: 0px;">
					<tr>
						<td><p><b>'.$customFieldsData['tasks_destinatario']['name'].'</b><br>'.$customFieldsData['tasks_destinatario']['val'].'</p></td>
						<td  align="right"><p><b>'.$customFieldsData['tasks_tel_contato_da_entrega']['name'].'</b><br>'.$customFieldsData['tasks_tel_contato_da_entrega']['val'].'</p></td>
					</tr>
				</table>


				<table style="padding-top:60px;width: 100%;padding-left: 0px;padding-right: 0px;">
					<tr>
						<td><img src="'.$barcode.'" ></td>
					</tr>
				</table>

				<table width="100%">
					<tr>
						<td style="background-color: black; color:white; vertical-align:middle; text-align:center; height:20px;line-height: 20px">24H</td>
					</tr>
				</table>

				<table width="100%">
					<tr>
						<td style="text-align:center; border-bottom:2px solid #000;"><b style="color:black" class="company-name-formatted">' . get_option('invoice_company_name') . '</b></td>
					</tr>
				</table>
				
			</td>

		</tr>

	</table>';


	$pdf->writeHTML($section_two, false, false, false, false, '');

}else{

	// client side code

	$printed_section = '
<div height="420px" style="margin-top:12px;">
	<table width="100%">
					<tr>
						<td width="25%" align="left"><img src="'.$qr_code_path.'" width="90px;"></td>
						<td width="50%" align="center"><p><br>'.pdf_logo_url_updated(250,'style="vertical-align: middle;text-align:center;"').'</p></td>
						<td width="25%" align="right"><img src="'.$qr_code_path.'" width="90px;"></td>
					</tr>
				</table>

				<table width="100%">
					<tr>
						<td style="background-color: black; color:white; vertical-align:middle; text-align:center; height:30px;width: 100%;line-height: 30px">SMART CODE</td>
					</tr>
				</table>

				<table style="padding-bottom:10px; border-bottom:2px solid #000;width: 100%;padding-left: 0px;padding-right: 0px;">
					<tr>
						<td><p><b>'.$customFieldsData['tasks_local_de_carga_contato']['name'].'</b><br>'.$customFieldsData['tasks_local_de_carga_contato']['val'].'</p></td>
						<td align="right">
						<p><b>'.$customFieldsData['tasks_tel_contato_carga']['name'].'</b><br>'.$customFieldsData['tasks_tel_contato_carga']['val'].'</p>
						</td>
					</tr>
					<tr>
						<td width="50%" align="right"></td>
						<td width="50%" align="right"><p><b>'._l('project_discussion_subject').'</b><br>'.$task->name.'</p></td>
					</tr>
				</table>

				<table style="padding-bottom:40px; border-bottom:2px solid #000;width: 100%;padding-left: 0px;padding-right: 0px;">
					<tr>
						<td><p><b>'.$customFieldsData['tasks_destinatario']['name'].'</b><br>'.$customFieldsData['tasks_destinatario']['val'].'</p></td>
						<td  align="right"><p><b>'.$customFieldsData['tasks_tel_contato_da_entrega']['name'].'</b><br>'.$customFieldsData['tasks_tel_contato_da_entrega']['val'].'</p></td>
					</tr>
				</table>

				<table style="padding-top:60px;width: 100%;padding-left: 0px;padding-right: 0px;">
					<tr>
						<td><img src="'.$barcode.'" ></td>
					</tr>
				</table>

				<table width="100%">
					<tr>
						<td style="background-color: #000; color:white; vertical-align:middle; text-align:center; height:20px;line-height: 20px;">24H</td>
					</tr>
				</table>

				<table width="100%">
					<tr>
						<td style="text-align:center; border-bottom:2px solid #000;"><b style="color:black" class="company-name-formatted">' . get_option('invoice_company_name') . '</b></td>
					</tr>
				</table>
</div>

	';

	$zones_section ='
	<style>p{ font-size:12px; }</style>
	<table width="100%" style="padding-top:5px;">';


	$zones_section .='<tr>';
        
        
        $zones_section .='<td width="50%">';
        if(in_array(1, $zones)){
            $zones_section .= $printed_section;
        }
        $zones_section .='</td>';


        $zones_section .='<td width="50%">';
        if(in_array(2, $zones)){
            $zones_section .= $printed_section;
        }
        $zones_section .='</td></tr><tr>';


        $zones_section .='<td width="50%">';
        if(in_array(3, $zones)){
            $zones_section .= $printed_section;
        }
        $zones_section .='</td>';


        $zones_section .='<td width="50%">';
        if(in_array(4, $zones)){
            $zones_section .= $printed_section;
        }
        $zones_section .='</td></tr>';


	$zones_section .='</table>';
	

	$pdf->writeHTML($zones_section, false, false, false, false, '');
}

      
	$pdf->AddPage();


}


	$lastPage = $pdf->getPage();
	$pdf->deletePage($lastPage);






