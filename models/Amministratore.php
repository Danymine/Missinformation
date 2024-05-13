<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Amministratore extends Model
{
    public $id;
    public $username;
    public $password;
    public $conferma;
    public $email;

    public $_user = [
      [
        "id" => 1,
        "username" => "Danymine",
        "password" => "PasswordInventata1",
        "email" => "Daniele@gmail.com"
      ],
      [
        "id" => 2,
        "username" => "Federico",
        "password" => "PasswordInventata1",
        "email" => "federico@gmail.com"
      ]
    ];

    public function __construct($utente){

      $this->email= $utente->email;
      $this->password= $utente->password;
    }

    public function rules()
    {
        return [
            // username and password are both required

            [['password', 'email'], 'required'],
            ['email', 'email'],
            [['username', 'conferma'], 'safe']
        ];
    }

    public function isAmministratore(){

      for($i=0; $i<count($this->_user); $i++){

        if($this->_user[$i]["email"] == $this->email and $this->_user[$i]["password"] == $this->password){

          return true;
        }
      }

      return false;
    }
}

?>
