<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

/** Signup class **/

class Signup {  
    use MainController;  
    
    public function index() {  
        $data = []; // Initialize the data array  

        if ($_SERVER['REQUEST_METHOD'] == "POST") {  
            $user = new \Model\User;  

            if ($user->validate($_POST)) {  
                $user->insert($_POST);  
                redirect("login");  
            }  

            $data['errors'] = $user->errors; // Note: Remove the $ sign before 'errors'  
        }  

        $this->view('signup', $data);  
    }  
}