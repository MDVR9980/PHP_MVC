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
			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
			$data['date'] = date("Y-m-d H:i:s");
			$data['date_created'] = date("Y-m-d H:i:s");

			$this->insert($data);
			redirect('login');
		}
	}

    public function login($data) {
		$row = $this->first([$this->loginUniqueColumn=>$data[$this->loginUniqueColumn]]);

		if($row) {

			//confirm password
			if(password_verify($data['password'], $row->password)) {
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