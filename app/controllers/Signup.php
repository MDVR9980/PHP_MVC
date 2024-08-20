<?php

/** Signup class **/

class Signup {  
    use Controller;  
    
    public function index() {  
        $data = []; // Initialize the data array  

        if ($_SERVER['REQUEST_METHOD'] == "POST") {  
            $user = new User;  

            if ($user->validate($_POST)) {  
                $user->insert($_POST);  
                redirect("login");  
            }  

            $data['errors'] = $user->errors; // Note: Remove the $ sign before 'errors'  
        }  

        $this->view('signup', $data);  
    }  
}