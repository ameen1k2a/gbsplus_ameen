<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->user_id = $this->session->userdata('user_id');
        $this->user_type = $this->session->userdata('user_type');
        $current_method = $this->router->fetch_method();

    	if ($this->user_id && $current_method !== 'logout' && $current_method !== 'refresh_csrf') {
           
            if($this->user_type == 'admin'){
                redirect('admin');
            } else{
                redirect('user');
            }
            
        }
       
      
    }

    public function index()
    {
        $data['title'] = 'Login';
        
    
        if ($this->user_id) {
            redirect($this->user_type);
        } else {
            if ($this->input->is_ajax_request() && $this->input->post('login')) {
                // Set content type to JSON
                $this->output->set_content_type('application/json');
                
                if ($this->validate_login()) {
                    $this->form_validation->set_rules('password', 'Password', 'callback_check_database');
                    $this->form_validation->set_message('check_database', "Incorrect email or password.");
    
                    if ($this->form_validation->run()) {
                        $this->session->set_flashdata('success', 'Login Success');
                        $this->output->set_output(json_encode(['success' => true]));
                    } else {
                        // Set JSON response for validation errors
                        $this->output->set_output(json_encode(['error' => [
                            'password' => form_error('password')
                        ]]));
                    }
                } else {
                    // Set JSON response for general errors
                    $this->output->set_output(json_encode([
                        'error' => [
                            'email' => form_error('email'),
                            'password' => form_error('password')
                        ]
                    ]));
                }
                return; // Stop execution here
            } else {
                // Load the login view for non-AJAX requests
                $this->load->view('login', $data);
            }
        }
    }
    

    public function validate_login()
    {

        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        return $this->form_validation->run();
    }

    function check_database()
    {
        $this->load->helper('security');

        $this->load->model('Login_model');
        $login_details = $this->input->post();
        $login_details = $this->security->xss_clean($login_details);
        $email = $login_details['email'];
        $password = $login_details['password'];

        $login_result = $this->Login_model->login($email, $password);
        if ($login_result) {
            $this->session->set_userdata('user_id', $login_result->id); 
            $this->session->set_userdata('email', $login_result->email);
            $this->session->set_userdata('user_type', $login_result->user_type);  

            return true; 
        }
        return false; 
    }


    public function logout()
    {
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('user_type');
            
            //session_destroy();
            $this->session->set_flashdata('success', 'Logout Success');
            redirect('login');
        } else {
            $this->session->set_flashdata('error', 'Not logged in');
            redirect('login');
        }
    }

    public function refresh_csrf() {
        $csrf = array(
            'csrf_token_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );
        echo json_encode($csrf);
    }

    public function error(){
        $this->load->view('error_page');
    }
}
