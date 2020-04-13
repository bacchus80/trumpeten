<?php

class Mailtemplates_model extends CI_Model
{

    function get_all_email_templates()
    {
        $date = date("Y-m-d", strtotime("-1 months"));

        $this->db->select('*');
        $q = $this->db->get('mail_template');
        $response = $q->result_array();

        return $response;
    }

}
