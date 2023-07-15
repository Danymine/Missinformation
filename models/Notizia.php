<?php

  namespace app\models;

  use Yii;
  use yii\base\Model;


  class Notizia extends Model{

    public $testo, $percorso, $id, $tipo;

    public function __construct($id){

      $this->id= $id;
    }

    public function rules() {
       return [
           [['testo', 'tipo'], 'required'],
       ];
     }

    public function setNotizia($testo){

      $this->testo = $testo;
      return 1;
    }

    public function getNotizia(){

      return 1;
    }

  }
