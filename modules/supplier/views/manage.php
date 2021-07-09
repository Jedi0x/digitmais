<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <div class="_buttons">
             

              <div class="visible-xs">
                <div class="clearfix"></div>
              </div>
            </div>
            <div class="clearfix"></div>
            <hr class="hr-panel-heading" />
            <div class="clearfix mtop20"></div>
              <?php
              $table_data = array(
                _l('invoice_dt_table_heading_number'),
                _l('invoice_dt_table_heading_amount'),
                _l('invoice_total_tax'),
                array(
                  'name'=>_l('invoice_estimate_year'),
                  'th_attrs'=>array('class'=>'not_visible')
                ),
                _l('invoice_dt_table_heading_date'),
                array(
                  'name'=>_l('invoice_dt_table_heading_client'),
                  'th_attrs'=>array('class'=>(isset($client) ? 'not_visible' : ''))
                ),
        
                _l('invoice_dt_table_heading_duedate'));
              

              $table_data = hooks()->apply_filters('order_table_columns', $table_data);

              render_datatable($table_data,'order',[],[
               'data-last-order-identifier' => 'order',
               'data-default-order'         => get_table_last_order('order'),
             ]);
             ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>
<script>
  $(function(){
    var orderServerParams = {};
    $.each($('._hidden_inputs._filters input'),function(){
      orderServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
    });
    orderServerParams['exclude_inactive'] = '[name="exclude_inactive"]:checked';
    var tAPI = initDataTable('.table-order', admin_url+'supplier/order_table', [0], [0], orderServerParams,<?php echo hooks()->apply_filters('customers_table_default_order', json_encode(array(2,'asc'))); ?>);
    $('input[name="exclude_inactive"]').on('change',function(){
      tAPI.ajax.reload();
    });
  });
</script>
</body>
</html>
