<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**  {CLASSNAME} class **/
class {CLASSNAME} {
    use Model;

    protected $table = '{table}';
    protected $primaryKey = 'id';

    protected $loginUniqueColumn = 'email';

    protected $secretKey = '@@darkday@@';

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
}