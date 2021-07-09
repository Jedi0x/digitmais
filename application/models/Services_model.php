<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Services_model extends App_Model
{

    public function get($slug = false, $where = [])
    {

        if ((is_array($where) && count($where) > 0) || (is_string($where) && $where != '')) {
            $this->db->where($where);
        }

        $this->db->where('is_publish', 1);
        $this->db->where('rel_type', 'supplier_offer');

        if ($slug) {
            $this->db->where('slug', $slug);
            
            $client = $this->db->get(db_prefix() . 'items')->row();
            return $client;
        }

        
        $this->db->order_by('id', 'asc');
        return $this->db->get(db_prefix() . 'items')->result_array();
    }


    public function get_by_id($id)
    {
        $this->db->where('is_publish', 1);
        $this->db->where('rel_type', 'supplier_offer');
        $this->db->where('id', $id);  
        $client = $this->db->get(db_prefix() . 'items')->row();
        return $client;
        
    }


    public function featured_services()
    {
        $this->db->order_by('rand()');
        $this->db->limit(10);
         $this->db->where('is_publish', 1);
        $this->db->where('rel_type', 'supplier_offer');
        return $this->db->get(db_prefix() . 'items')->result_array();
    }

    public function search_result($keyword)
    {   
        $this->db->where('is_publish', 1);
        $this->db->where('rel_type', 'supplier_offer');
        $this->db->like('description', $keyword, 'both');
        return $this->db->get(db_prefix() . 'items')->result_array();
    }


     public function get_orders()
    {
        $this->db->select('*, ' . db_prefix() . 'currencies.id as currencyid, ' . db_prefix() . 'invoices.id as id, ' . db_prefix() . 'currencies.name as currency_name');
        $this->db->from(db_prefix() . 'invoices');
        $this->db->join(db_prefix() . 'currencies', '' . db_prefix() . 'currencies.id = ' . db_prefix() . 'invoices.currency', 'left');

        $this->db->join(db_prefix() . 'offer_order', '' . db_prefix() . 'offer_order.invoice_id = ' . db_prefix() . 'invoices.id', 'left');
        $this->db->order_by('number,YEAR(date)', 'desc');
        return $this->db->get()->result_array();
    }

   
}