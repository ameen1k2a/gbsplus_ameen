<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_controller extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
    	
        $this->load->model('User_model');

        $this->user_id = $this->session->userdata('user_id');
        $this->user_type = $this->session->userdata('user_type');

        if (!$this->user_id) {
            redirect('login');
        }

        if ($this->user_type === 'user' && $this->router->method !== 'user_info') {
            redirect('user');
        }
        
    }
	public function index()
	{
		$this->load->view('users');
	}

    public function users_list(){
		  	
        $fetch_data = $this->User_model->users_list(); 		
        
        $data = array();  
        $no = $_POST['start'] + 1;
       foreach($fetch_data as $row)  
       {   
            $sub_array = array();
    
            $encrypted_id = base64_encode($row->id);
            
            $sub_array[] = '<span class="custom-checkbox">
                                <input type="checkbox" id="checkbox' . $no . '" name="options[]" value="' . $encrypted_id . '">
                                <label for="checkbox' . $no . '"></label>
                            </span>'; 
            $sub_array[] = $row->name; 
            $sub_array[] = $row->email;
            $sub_array[] = $row->phone; 
            $sub_array[] = $row->address; 
            $sub_array[] = '<a href="#editUserModal" class="edit" data-toggle="modal" data-enc_id="' . $encrypted_id . '"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                            <a href="#deleteUserModal" class="delete" data-toggle="modal" data-enc_id="' . $encrypted_id . '"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>';
           
            $data[] = $sub_array;
            $no++; 
       }  
       
       $output = array( 
            "draw"                =>     intval($_POST["draw"]), 
            "recordsTotal"        =>     $this->User_model->get_filtered_users_list_count(),  
            "recordsFiltered"     =>     $this->User_model->get_filtered_users_list_count(),  
            "data"                =>     $data  
       );  
       echo json_encode($output);  
    
          
    }

    public function add() {
        
        require(APPPATH . 'config/email.php');
        
        // Set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|xss_clean');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|numeric|xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'required|trim|xss_clean');
    
        // Validate the form
        if ($this->form_validation->run() == FALSE) {
            $errors = array(
                'name_error' => form_error('name'),
                'email_error' => form_error('email'),
                'password_error' => form_error('password'),
                'confirm_password_error' => form_error('confirm_password'),
                'phone_error' => form_error('phone'),
                'address_error' => form_error('address')
            );
            echo json_encode(['error' => $errors]);
            return;
        }
    
        // Prepare data for insertion
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT), // Hashing password
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address')
        );
    
        if ($this->User_model->insert_user($data)) {
            // Send the password to the user via email
            $this->load->library('email');
            $this->email->initialize($config); // Initialize with the config array
    
            $this->email->from($config['smtp_user'], 'Your Company Name');
            $this->email->to($data['email']);
            $this->email->subject('Welcome to Our Service');
            $this->email->message('Your account has been created. Here are your login details:<br><br>' .
                'Email: ' . $data['email'] . '<br>' .
                'Password: ' . $this->input->post('password'));
    
            if ($this->email->send()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User added successfully and email sent.'
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'message' => 'User added successfully, but failed to send email: ' . $this->email->print_debugger()
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to add user'
            ]);
        }
    }
    
    public function edit() {

        require(APPPATH . 'config/email.php');

        $encrypted_id = $this->input->post('enc_id');
        $decrypted_id = base64_decode($encrypted_id);
    
        // Set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean|callback_check_email_exists[' . $decrypted_id . ']');
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|xss_clean');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|numeric|xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'required|trim|xss_clean');
    
        // Validate the form
        if ($this->form_validation->run() == FALSE) {
            $errors = array(
                'edit_name_error' => form_error('name'),
                'edit_email_error' => form_error('email'),
                'edit_password_error' => form_error('password'),
                'edit_confirm_password_error' => form_error('confirm_password'),
                'edit_phone_error' => form_error('phone'),
                'edit_address_error' => form_error('address')
            );
            echo json_encode(['error' => $errors]);
            return;
        }
    
        // Fetch the original user data
        $original_data = $this->User_model->get_user_by_id($decrypted_id);
    
        // Prepare data for update
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address')
        );
    
        // Update password only if provided
        if (!empty($this->input->post('password'))) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }
    
        // Update user and check the result
        if ($this->User_model->update_user($decrypted_id, $data)) {
            // Determine changes
            $changes = [];
            foreach ($data as $key => $value) {
                if ($key === 'password') {
                    if (!empty($this->input->post('password'))) {
                        $changes['Password'] = 'Updated to: ' . $this->input->post('password'); // Include the new password
                    }
                } elseif ($original_data->$key !== $value) {
                    $changes[ucfirst($key)] = 'Updated to: ' . $value;
                }
            }

    
            // Send email with updated details if there are changes
            if (!empty($changes)) {
                // Load email configuration
                
                $this->load->library('email', $config);
    
                $this->email->from($config['smtp_user'], 'Your Company Name');
                $this->email->to($data['email']);
                $this->email->subject('Your Profile Has Been Updated');
    
                // Construct the email message with updated details
                $message = "Hello " . $data['name'] . ",\n\nYour profile has been updated with the following changes:\n\n";
                foreach ($changes as $field => $update) {
                    $message .= "$field: $update\n";
                }
                $message .= "\nThank you,\nYour Company Name";
    
                $this->email->message($message);
    
                if ($this->email->send()) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'User updated successfully and email sent.'
                    ]);
                } else {
                    echo json_encode([
                        'success' => true,
                        'message' => 'User updated successfully, but failed to send email: ' . $this->email->print_debugger()
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => true,
                    'message' => 'User updated successfully with no email notification (no changes detected).'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update user'
            ]);
        }
    }
    

    public function check_email_exists($email, $user_id) {
        
        if ($this->User_model->is_email_unique_except($email, $user_id)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_email_exists', 'The {field} field must contain a unique value.');
            return FALSE;
        }
    }

    public function get_user() {
       
        $encrypted_id = $this->input->post('id');
        
        // Decrypt the ID
        $decrypted_id = base64_decode($encrypted_id);
    
        // Fetch the user data from the database
        $user = $this->User_model->get_user_by_id($decrypted_id);
    
        if ($user) {
            echo json_encode([
                'success' => true,
                'user' => $user
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
    }

    public function delete() {
        $delete_ids = $this->input->post('delete_ids');

        // Check if delete_ids is empty
        if (empty($delete_ids)) {
            echo json_encode([
                'success' => false,
                'message' => 'No users selected for deletion'
            ]);
            return;
        }

        $ids = explode(',', $delete_ids);
    
        // Decrypt IDs
        $decrypted_ids = array_map('base64_decode', $ids);
    
        // Proceed with deletion logic
        $this->load->model('User_model');
        $result = $this->User_model->delete_users($decrypted_ids);
    
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Users deleted successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to delete users'
            ]);
        }
    }

  
   public function user_info(){

    if ($this->user_type !== 'user') {
        show_error('Access Denied: Only users can access this page.', 403);
        return;
    }

    $data['user'] = $this->User_model->get_user_by_id($this->user_id);
    $this->load->view('user_info', $data);
   }
    
    
    
    
}
