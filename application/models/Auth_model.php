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
        $email       = $data['email'];
        $raw_password = $data['password'];

        // SQL injection fixed with CI3 query binding
        $userResult  = $this->db->query("SELECT * FROM users WHERE email = ?", array($email));
        $userRows    = $userResult->num_rows();

        if ($userRows == 1) {
            $userData = $userResult->result();
            $user     = $userData[0];

            $stored_hash    = $user->password;
            $password_valid = false;

            // Try bcrypt first (new format, starts with $2y$)
            if (strlen($stored_hash) > 32 && password_verify($raw_password, $stored_hash)) {
                $password_valid = true;
            }
            // Fall back to MD5 legacy - migrate silently to bcrypt
            elseif (strlen($stored_hash) === 32 && $stored_hash === md5($raw_password)) {
                $password_valid = true;
                $new_hash = password_hash($raw_password, PASSWORD_BCRYPT);
                $this->db->update('users', array('password' => $new_hash), array('id' => $user->id));
            }

            $result = array();
            if ($password_valid) {
                if ($user->status == 0) {
                    $result['valid'] = false;
                    $result['error'] = 'Your account is suspended! Please contact to Administrator!';
                } else {
                    $result['valid']      = true;
                    $result['user_id']    = $user->id;
                    $result['user_email'] = $user->email;
                    $result['role_id']    = $user->role_id;
                    $result['outlet_id']  = $user->outlet_id;
                }
            } else {
                $result['valid'] = false;
                $result['error'] = 'Invalid Password!';
            }

            unset($userData);
            return $result;
        } else {
            $result['valid'] = false;
            $result['error'] = 'Email Address do not exist at the system!';

            unset($userRows);
            unset($userResult);
            return $result;
        }
    }

    public function encryptPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
