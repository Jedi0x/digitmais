<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Test extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('services_model');
    }
    
    public function index()
    {
        define('CONTACT_REGISTERING', true);
        $clientid = $this->clients_model->add([
            'billing_street'      => 'test',
            'billing_city'        => 'test',
            'billing_state'       => 'test',
            'billing_zip'         => 'test',
            'billing_country'     =>  0,
            'firstname'           => 'test',
            'lastname'            => 'test',
            'email'               => 'blackdesire002@gmail.com',
            'contact_phonenumber' => 't43443434343est',
            'website'             => null,
            'title'               => 'test',
            'password'            => 'test',
            'company'             => 'test',
            'vat'                 => '',
            'phonenumber'         => '324234234232434',
            'country'             => 0,
            'city'                => 'test',
            'address'             => 'test',
            'zip'                 => 'test',
            'state'               => 'test',
            'custom_fields'       => isset($data['custom_fields']) && is_array($data['custom_fields']) ? $data['custom_fields'] : [],
        ], true);

        if ($clientid) {
            hooks()->do_action('after_client_register', $clientid);

            if (get_option('customers_register_require_confirmation') == '1') {
                send_customer_registered_email_to_administrators($clientid);

                $this->clients_model->require_confirmation($clientid);
                set_alert('success', _l('customer_register_account_confirmation_approval_notice'));
                redirect(site_url('authentication/login'));
            }

            send_customer_registered_email_to_administrators($clientid);

        
        }

    
    }

    

}
