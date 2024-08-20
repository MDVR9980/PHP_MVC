<?php

defined('ROOTPATH') OR exit('Access Denied!');

/** login class **/

class Login {  
    use Controller;  

    public function index() {  
        $data = []; // Initialize the data array  

        if ($_SERVER['REQUEST_METHOD'] == "POST") {  
            $user = new User; 
            $arr['email'] = $_POST['email'];  
            $row = $user->first($arr);  

            if ($row) {  
                if ($row->password === $_POST['password']) {  
                    $_SESSION['USER'] = $row;  
                    redirect('home');  
                }  
            }  
            
            $user->errors['email'] = "Wrong email or password";  
            $data['errors'] = $user->errors;
        }  
        

        $this->view('login', $data);  
    }  
}