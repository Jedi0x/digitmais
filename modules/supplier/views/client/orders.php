<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s section-heading section-invoices">
    <div class="panel-body">
        <h4 class="no-margin section-text"><?php echo _l('orders'); ?></h4>
        
    </div>
</div>
<div class="panel_s">
 <div class="panel-body">
     <hr />
     <table class="table dt-table table-invoices" data-order-col="1" data-order-type="desc">
         <thead>
            <tr>
                <th class="th-invoice-number"><?php echo _l('clients_invoice_dt_number'); ?></th>
                <th class="th-invoice-date"><?php echo _l('clients_invoice_dt_date'); ?></th>
                <th class="th-invoice-duedate"><?php echo _l('clients_invoice_dt_duedate'); ?></th>
                <th class="th-invoice-amount"><?php echo _l('clients_invoice_dt_amount'); ?></th>
                <?php
                $custom_fields = get_custom_fields('invoice',array('show_on_client_portal'=>1));
                foreach($custom_fields as $field){ ?>
                    <th><?php echo $field['name']; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $order){ ?>
                <tr>
                    <td data-order="<?php echo $order['number']; ?>"><a href="<?php echo site_url('invoice/' . $order['id'] . '/' . $order['hash']); ?>" class="invoice-number"><?php echo format_invoice_number($order['id']); ?></a></td>
                    <td data-order="<?php echo $order['date']; ?>"><?php echo _d($order['date']); ?></td>
                    <td data-order="<?php echo $order['duedate']; ?>"><?php echo _d($order['duedate']); ?></td>
                    <td data-order="<?php echo $order['total']; ?>"><?php echo app_format_money($order['total'], $order['currency_name']); ?></td>
                    
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
