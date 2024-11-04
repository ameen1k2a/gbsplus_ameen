<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{

    public function login($email, $password)
    {
       
        if ($email && $password) {
            $this->db->select('id, email, password,user_type');
            $this->db->from('users');
            $this->db->where('email', $email);
            $this->db->limit(1);
            $query = $this->db->get();
        
            if ($query->num_rows() == 1) {
                $user = $query->row();
        
                if (password_verify($password, $user->password)) {
                    return $user; 
                } else {
                    
                    return false;
                }
            } else {
               
                return false;
            }
        }
         else {
            return false;
        }
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
