<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('services_model');
        $this->load->model('clients_model');
    }

    public function index()
    {   
        $data['title']  = 'Home';
        $data['featured_offers'] = $this->services_model->featured_services();
        $this->load->view('front-end/index',$data);
    }

    public function profile($userid)
    {   
        $contact = get_primary_contact_user_id($userid);
        $data['title']  = get_supplier_full_name($contact);
        $where['userid'] = $userid;
        $data['offers'] = $this->services_model->get('',$where);
        $data['client'] =  $this->clients_model->get($userid);
        $data['contact'] = $this->clients_model->get_contact($contact);
        $this->load->view('front-end/profile',$data);
    }


}
