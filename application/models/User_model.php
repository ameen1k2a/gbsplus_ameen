<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function users_list()
	{
		$this->make_users_list_query();

		if ($_POST["length"] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}


	function make_users_list_query()
	{
		$this->db->from('users');
		

		$contact_select_column = array("*");
		$contact_order_column = array(null,"name","email","phone","address",null);
		$this->db->select($contact_select_column);
		$this->db->where('user_type !=','admin');
		

		if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
			$searchValue = $_POST["search"]["value"];
			$this->db->group_start();
			$this->db->like("name", $searchValue);
			$this->db->or_like("email", $searchValue);
			$this->db->or_like("phone", $searchValue);
			$this->db->or_like("address", $searchValue);
			$this->db->group_end();
		}
		if (isset($_POST["order"])) {
			$this->db->order_by($contact_order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
			$this->db->order_by('id', 'DESC');
		}


	}

	function get_filtered_users_list_count()
	{
		$this->make_users_list_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

    /* public function insert_user($data) {
        
        return $this->db->insert('users', $data);
    } */

	public function insert_user($data) {
		// Insert user data
		if ($this->db->insert('users', $data)) {
			// Get the ID of the inserted user
			$insert_id = $this->db->insert_id();
	
			// Fetch the inserted user's details
			$this->db->where('id', $insert_id);
			$query = $this->db->get('users');
	
			// Return the user data as an array
			return $query->row_array();
		} else {
			// Return false if the insert failed
			return false;
		}
	}
	

    public function update_user($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('users', $data);
	
		// Fetch and return the updated user data
		$this->db->where('id', $id);
		return $this->db->get('users')->row_array();
	}
	

    public function get_user_by_id($id) {
        $this->db->select('name, email, phone, address');
        $this->db->where('id', $id);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            return $query->row(); 
        } else {
            return null; // No user found
        }
    }

	public function is_email_unique_except($email, $user_id) {
        $this->db->where('email', $email);
        $this->db->where('id !=', $user_id);
        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	public function delete_users($ids) {
		$this->db->where_in('id', $ids);
		return $this->db->delete('users');
	}
	
}
