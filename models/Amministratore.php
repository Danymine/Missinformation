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
        "password" => "Grottaglie1",
        "email" => "d.parisi16@studenti.uniba.it"
      ],
      [
        "id" => 2,
        "username" => "Federico",
        "password" => "Paolosesto0",
        "email" => "f.pignatelli18@studenti.uniba.it"
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
