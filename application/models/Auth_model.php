<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function verifyLogIn($data) {
        $email 			= $data['email'];
        $password 		= $this->encryptPassword($data['password']);
        
        $userResult 	= $this->db->query("SELECT * FROM users WHERE email = '$email' ");
		$userRows 		= $userResult->num_rows();
        if ($userRows == 1) {
	        $userData	= $userResult->result();
	        
            $result 	= array();
            if ($userData[0]->password == $password) {
                if ($userData[0]->status == 0) {
                    $result['valid'] 		= false;
                    $result['error'] 		= 'Your account is suspended! Please contact to Administrator!';
                } else {
                    $result['valid'] 		= true;
                    $result['user_id'] 		= $userData[0]->id;
                    $result['user_email'] 	= $userData[0]->email;
                    $result['role_id'] 		= $userData[0]->role_id;
                    $result['outlet_id'] 	= $userData[0]->outlet_id;
                }
            } else {
                $result['valid'] 			= false;
                $result['error'] 			= 'Invalid Password!';
            }
            return $result;
            
            unset($userData);
        } else {
            $result['valid'] 				= false;
            $result['error'] 				= 'Email Address do not exist at the system!';

            return $result;
        }
        unset($userRows);
        unset($userResult);
    }

    public function encryptPassword($password) {
        return md5("$password");
    }
}
