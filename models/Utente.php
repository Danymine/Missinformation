<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Utente extends Model
{
    public $id;
    public $username;
    public $password;
    public $conferma;
    public $email;


    public function rules()
    {
        return [
            // username and password are both required

            [['password', 'email'], 'required'],
            ['email', 'email'],
            [['username', 'conferma'], 'safe']
        ];
    }
}

?>
