<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body accounting-template">
                        <h4 class="no-margin"><?php echo html_escape(_l($header)) ?></h4>
                        <hr>
                        <?php $this->load->view('service'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        "use strict"

        appValidateForm('#offerProductsForm', {
            name: 'required',
            price: 'required',
            description: 'required',
            currency: 'required',
            attachments: 'required',
            offer_time: 'required',
            offer_video_number: 'required'
        });

    });


    
</script>
<script>
    init_editor("#long_description");
</script>