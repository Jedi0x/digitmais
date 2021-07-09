<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Service extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('services_model');
    }
    public function index()
    {
        $data['title']  = 'Search Result';
        $data['offers'] = $this->services_model->get();
        $this->load->view('front-end/search-result',$data);
    }

    public function detial($slug)
    {   
        $offer = $this->services_model->get($slug);
        $data['title']  = $offer->description;
        $data['offer'] = $offer;
        $data['contact'] = get_primary_contact_user_id($offer->userid);
        $this->load->view('front-end/offer-detail',$data);
    }
    public function results($search)
    {
        $search = urldecode($search);
        $data['title']  = 'Search result for "'.$search.'"';
        $data['offers'] = $this->services_model->search_result($search);
        $data['keyword'] = $search;
        $this->load->view('front-end/search-result',$data);
    }

    public function proceed()
    {

        if ($this->input->post()) {
   
                $data = $this->input->post();

                define('CONTACT_REGISTERING', true);

                $clientid = $this->clients_model->add([
                    'billing_street'      => $data['address'],
                    'billing_city'        => $data['city'],
                    'billing_state'       => $data['state'],
                    'billing_zip'         => $data['zip'],
                    'billing_country'     => is_numeric($data['country']) ? $data['country'] : 0,
                    'firstname'           => $data['firstname'],
                    'lastname'            => $data['lastname'],
                    'email'               => $data['email'],
                    'contact_phonenumber' => $data['contact_phonenumber'],
                    'website'             => null,
                    'title'               => $data['title'],
                    'password'            => $data['passwordr'],
                    'company'             => $data['company'],
                    'vat'                 => isset($data['vat']) ? $data['vat'] : '',
                    'phonenumber'         => $data['phonenumber'],
                    'country'             => $data['country'],
                    'city'                => $data['city'],
                    'address'             => $data['address'],
                    'zip'                 => $data['zip'],
                    'state'               => $data['state'],
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

                    $this->load->model('authentication_model');

                    $logged_in = $this->authentication_model->login(
                        $this->input->post('email'),
                        $this->input->post('password', false),
                        false,
                        false
                    );

                    $redUrl = site_url();

                    if ($logged_in) {
                        hooks()->do_action('after_client_register_logged_in', $clientid);
                        set_alert('success', _l('clients_successfully_registered'));
                    } else {
                        set_alert('warning', _l('clients_account_created_but_not_logged_in'));
                        $redUrl = site_url('authentication/login');
                    }

                    send_customer_registered_email_to_administrators($clientid);
                   
                    $this->invoice($clientid,$data['offer_id']);
                   

                    redirect($redUrl);
                }
            
        }
    }

    public function invoice($client_id,$offer_id)
    {
        $offer_data = $this->services_model->get_by_id($offer_id);
        $invoice_data = service_invoice_data($offer_data,$client_id);
        $invoice_data['clientid'] = $invoice_data['clientid']->userid;
        $id = $this->invoices_model->add($invoice_data);
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update(db_prefix() . 'invoices', [
                'addedfrom' => 2,
            ]);
            $invoice = $this->invoices_model->get($id);

            $purchaseData = [];
            $purchaseData['invoice_id'] = $id;
            $purchaseData['client_id'] = $client_id;
            $purchaseData['offer_id'] = $offer_id;
            $purchaseData['created_at'] = date('Y-m-d H:i:s');

            $this->db->insert(db_prefix() . 'offer_order', $purchaseData);
        


            redirect(site_url("invoice/$id/$invoice->hash"));
        }
       
    }


    /* Check if client email exists/  ajax */
    public function contact_email_exists()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                // First we need to check if the email is the same
                $userid = $this->input->post('userid');
                if ($userid != '') {
                    $this->db->where('id', $userid);
                    $_current_email = $this->db->get(db_prefix() . 'contacts')->row();
                    if ($_current_email->email == $this->input->post('email')) {
                        echo json_encode(true);
                        die();
                    }
                }
                $this->db->where('email', $this->input->post('email'));
                $total_rows = $this->db->count_all_results(db_prefix() . 'contacts');
                if ($total_rows > 0) {
                    echo json_encode(false);
                } else {
                    echo json_encode(true);
                }
                die();
            }
        }
    }

}
