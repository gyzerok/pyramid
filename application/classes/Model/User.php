<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_User extends Model_Auth_User {

    protected $_belongs_to = array(
        'sponsor' => array(
            'model'       => 'User',
            'foreign_key' => 'sponsor_id'
        ),
    );

    public function rules()
    {
        return array(
            'username' => array(
                array('not_empty'),
                array('max_length', array(':value', 32)),
                array(array($this, 'unique'), array('username', ':value')),
            ),
            'password' => array(
                array('not_empty'),
            ),
            'email' => array(
                array('not_empty'),
                array('email'),
                array(array($this, 'unique'), array('email', ':value')),
            ),
            'sponsor_id' => array(
                array('not_empty')
            ),
        );
    }

    public function labels()
    {
        return array(
            'username'   => 'Логин',
            'email'      => 'Email',
            'password'   => 'Пароль',
            'sponsor_id' => 'Спонсор'
        );
    }
}
