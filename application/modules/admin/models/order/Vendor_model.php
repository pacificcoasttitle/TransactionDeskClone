<?php
class Vendor_model extends CI_Model
{

    public function __construct()
    {
        $this->table = 'pct_vendors';
    }

    public function get_vendors($params)
    {
        if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
            $keyword = trim($params['searchvalue']);

            if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("pct_vendors.transctee_name", $keyword)
                    ->or_like('pct_vendors.file_number', $keyword)
                    ->or_like('pct_vendors.account_number', $keyword)
                    ->or_like('pct_vendors.aba', $keyword)
                    ->or_like('pct_vendors.bank_name', $keyword)
                    ->or_like('pct_vendors.notes', $keyword)
                    ->or_like('pct_vendors.admin_notes', $keyword)
                    ->group_end();
            }
            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $venders_lists = array();

            $this->db->select('
                    pct_vendors.id,
                    pct_vendors.transctee_name,
                    pct_vendors.file_number,
                    pct_vendors.account_number,
                    pct_vendors.aba,
                    pct_vendors.bank_name,
                    pct_vendors.submitted,
                    pct_vendors.notes,
                    pct_vendors.admin_notes,
                    pct_vendors.approved_by,
                    pct_vendors.is_approved,
                    customer_basic_details.first_name,
                    customer_basic_details.last_name,
                ')
                ->from('pct_vendors')
                ->join('customer_basic_details', 'customer_basic_details.id = pct_vendors.approved_by', 'left');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $venders_lists = $query->result_array();
            }
        } else {

            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $venders_lists = array();

            $this->db->select('
                    pct_vendors.id,
                    pct_vendors.transctee_name,
                    pct_vendors.file_number,
                    pct_vendors.account_number,
                    pct_vendors.aba,
                    pct_vendors.bank_name,
                    pct_vendors.submitted,
                    pct_vendors.notes,
                    pct_vendors.admin_notes,
                    pct_vendors.approved_by,
                    pct_vendors.is_approved,
                    customer_basic_details.first_name,
                    customer_basic_details.last_name,
                ')
                ->from('pct_vendors')
                ->join('customer_basic_details', 'customer_basic_details.id = pct_vendors.approved_by', 'left');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $venders_lists = $query->result_array();
            }
        }
        // print_r($this->db->last_query());die;
        return array(
            'recordsTotal' => count($venders_lists),
            'recordsFiltered' => count($venders_lists),
            'data' => $venders_lists,
        );
    }

    public function update($data, $condition = array())
    {
        $table = $this->table;
        if (!empty($data)) {
            $data['updated_at'] = date("Y-m-d H:i:s");
            $update = $this->db->update($table, $data, $condition);
            return $update ? true : false;
        }
        return false;
    }

    public function insert($data = array())
    {
        $table = $this->table;
        if (!empty($data)) {
            $data['created_at'] = date("Y-m-d H:i:s");
            $insert = $this->db->insert($table, $data);
            return $insert ? $this->db->insert_id() : false;
        }
        return false;
    }

    public function delete($condition = array())
    {
        $table = $this->table;
        if (!empty($condition)) {
            // $data['id'] = date("Y-m-d H:i:s");
            $deleted = $this->db->delete($table, $condition);
            return $deleted ? true : false;
        }
        return false;
    }

    public function getDetails($id)
    {
        $table = $this->table;
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where('id', $id);
            $query = $this->db->get();
            return $query->row_array();
        }
        return false;
    }
}
