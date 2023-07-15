<?php

  namespace app\models;

  use Yii;
  use yii\base\Model;


  class FontiForm extends Model{

    public $id, $url;

    public function rules() {
       return [
           [['url'], 'required'],
           ['id', 'safe']
       ];
     }
  }
