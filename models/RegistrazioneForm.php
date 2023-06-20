<?php

namespace app\models;

use Yii;
use yii\base\Model;


class RegistrazioneForm extends Model
{
    public $nome;
    public $cognome;
    public $email;
    public $password;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
        ];
    }
}
