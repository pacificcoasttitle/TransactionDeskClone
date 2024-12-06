<?php
class FileDocument_model extends MY_Model
{
    public $_table = 'pct_file_documents';

    public function get_forms()
    {
        $userdata = $this->session->userdata('user');
        $this->db->select('*')
            ->from('pct_file_documents')
            ->join('pct_order_title_officers_forms', 'pct_file_documents.id = pct_order_title_officers_forms.form_id');
        $this->db->where('pct_order_title_officers_forms.user_id', $userdata['id']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_uploaded_documents_list($params)
    {
        $userdata = $this->session->userdata('user');
        // $this->db->select('*')
        //     ->from('pct_file_documents');
        // $this->db->where('added_by', $userdata['id']);
        // $query = $this->db->get();
        // $result = $query->result();

        $this->db->where('added_by', $userdata['id']);
        $this->db->where('is_desk_file', 1);
        $this->db->from('pct_file_documents');
        $total_records = $this->db->count_all_results();

        $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';

        $document_lists = array();
        if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
            $keyword = $params['searchvalue'];

            if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like('name', $keyword)
                    ->or_like('order_number', $keyword)
                    ->group_end();
            }

            $this->db->where('added_by', $userdata['id']);
            $this->db->where('is_desk_file', 1);
            $this->db->from('pct_file_documents');
            $filter_total_records = $this->db->count_all_results();

            if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like('name', $keyword)
                    ->or_like('order_number', $keyword)
                    ->group_end();
            }

            $this->db->where('added_by', $userdata['id']);
            $this->db->where('is_desk_file', 1);

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
            $query = $this->db->get('pct_file_documents');

            if ($query->num_rows() > 0) {
                $document_lists = $query->result_array();
            }
        } else {

            $this->db->where('added_by', $userdata['id']);
            $this->db->where('is_desk_file', 1);
            $this->db->from('pct_file_documents');

            $filter_total_records = $this->db->count_all_results();

            $this->db->where('added_by', $userdata['id']);
            $this->db->where('is_desk_file', 1);
            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
            $query = $this->db->get('pct_file_documents');

            if ($query->num_rows() > 0) {
                $document_lists = $query->result_array();
            }
        }

        return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $document_lists,
        );

    }
}
