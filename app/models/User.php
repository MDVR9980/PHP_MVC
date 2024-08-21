<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**  User class **/
class User {
    use Model;

    protected $table = "users";
    protected $primaryKey = "id";

    protected $loginUniqueColumn = 'email';

    protected $secretKey = "@@darkday@@";

    protected $allowedColumn = [
        'username',
        'email',
        'password',
    ];
    /********************************
    *   rules include :
    *   required
    *   alpha
    *   email
    *   numeric
    *   unique
    *   symbol
    *   not_less_than_8_chars
    *   alpha_numeric_symbol
    *   alpha_numeric
    *   alpha_symbol
    ********************************/
    protected $validationRules = [
        'username' => [
            'alpha_numeric',
            'required',
        ],
        'email' => [
            'email',
            'unique',
            'required',
        ],
        'password' => [
            'not_less_than_8_chars',
            'required',
        ],
    ];

	public function signup($data) {
		if($this->validate($data)) {
			//add extra user columns here
			$pass = md5($this->secretKey . $data['password'] . $this->secretKey);
            $data['password'] = $pass;
			// $data['date'] = date("Y-m-d H:i:s");
			// $data['date_created'] = date("Y-m-d H:i:s");

			$this->insert($data);
			redirect('login');
		}
	}

    public function login($data) {
		$row = $this->first([$this->loginUniqueColumn=>$data[$this->loginUniqueColumn]]);

		if($row) {
            $pass = md5($this->secretKey . $data['password'] . $this->secretKey);
			//confirm password
			if($row->password == $pass) {
				$ses = new \Core\Session;
				$ses->auth($row);
				redirect('home');
			}else {
				$this->errors[$this->loginUniqueColumn] = "Wrong $this->loginUniqueColumn or password";
			}
		}else {
			$this->errors[$this->loginUniqueColumn] = "Wrong $this->loginUniqueColumn or password";
		}
	}
}