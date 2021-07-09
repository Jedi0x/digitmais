<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Service_model extends App_Model
{
    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = db_prefix() . 'items';
    }

    /**
     * Add new Invoice product to db
     * @param array $data array of fields
     * @return int|boolean if successfull $insertid else false if failed
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

    /**
     * Gets a single Product from Invoice product table in db
     * @param int $id of Invoice product
     * @return object
     */
    public function get($id)
    {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row();
    }

    /**
     * updates Invoice product in db
     * @param int $id of Invoice product
     * @param data array of fields to edit
     * @return boolean
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return $this->db->error();
    }

    /**
     * deletes Invoice product form db
     * @param int $id of Invoice product to delete
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return $this->db->error();
    }

    /**
     * gets all Invoice products in db for logged in client
     * @return array
     */
    public function get_all($category = null)
    {
        $this->load->model('client_groups_model');
        $client_id = get_client_user_id();
        $client_groups = $this->client_groups_model->get_customer_groups($client_id);


        $this->db->group_start();
        foreach ($client_groups as $cgroup) {
            $this->db->or_where('customer_group', $cgroup['groupid']);
        }
        $this->db->or_where('customer_group');
        $this->db->group_end();

        $this->db->group_start();
        $this->db->or_where('client_id', $client_id);
        $this->db->or_where('client_id');
        $this->db->group_end();

        if($category){
            $this->db->where('group', $category);
        }

        return $this->db->get($this->table)->result();
    }

    /**
     * Add new purchase
     * @param array $data array of fields
     * @return int|boolean if successfull $insertid else false if failed
     */
    public function record_purchase($data)
    {
        $this->db->insert(db_prefix() . 'product_purchase_log', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            return $insert_id;
        }
        return false;
    }

    public function change_publish_status($id,$status)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, array('is_publish' => $status));

        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return $this->db->error();
    }


    public function change_featured_status($id,$status)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, array('is_featured' => $status));

        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return $this->db->error();
    }

    public function get_orders()
    {
        $offers = array();
        $this->db->where('rel_type', 'supplier_offer');
        $this->db->where('userid', get_client_user_id());
        $offer =  $this->db->get(db_prefix() . 'items')->result_array();

        foreach ($offer as $k => $v) {
            array_push($offers,$v['id']);
        }

        $this->db->select('*, ' . db_prefix() . 'currencies.id as currencyid, ' . db_prefix() . 'invoices.id as id, ' . db_prefix() . 'currencies.name as currency_name');
        $this->db->from(db_prefix() . 'offer_order');
        $this->db->join(db_prefix() . 'invoices', '' . db_prefix() . 'invoices.id = ' . db_prefix() . 'offer_order.invoice_id', 'left');
        $this->db->join(db_prefix() . 'currencies', '' . db_prefix() . 'currencies.id = ' . db_prefix() . 'invoices.currency', 'left');
        $this->db->where_in(db_prefix() . 'offer_order.offer_id',$offers);
        $this->db->order_by('number,YEAR(date)', 'desc');
        return $this->db->get()->result_array();
    }
}
