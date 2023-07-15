<?php

  namespace app\models;

  use Yii;
  use yii\base\Model;
  use app\models\FontiForm;


  class ListaNera extends Model{

    public $id_utente, $id_fonte;

    public function __construct($id_utente, $id_fonte){

      $this->id_utente= $id_utente;
      $this->id_fonte= $id_fonte;
    }
    
    public function addFonteListanera(){

        $arr = [
          "status_request" => true,
          "message" => "La fonte selezionata è stata inserita nella sua lista nera. Non riceverà più notizie da quest'ultima."
        ];

        $post = Yii::$app->db->createCommand('SELECT id FROM fonte WHERE link=:parms')->bindValue(':parms', $this->id_fonte)->queryOne();
        $post2 = Yii::$app->db->createCommand('SELECT id FROM utente WHERE nome=:parms')->bindValue(':parms', $this->id_utente)->queryOne();
        if(!empty($post)){

          Yii::$app->db->createCommand()->insert('lista_nera', [
              'id_utente' => $post2["id"],
              'id_fonte' =>  $post["id"]
          ])->execute();

          return $arr;
        }
        else{

          Yii::$app->db->createCommand()->insert('fonte', [
              'link' =>  $this->id_fonte
          ])->execute();
          $post = Yii::$app->db->createCommand('SELECT id FROM fonte WHERE link=:parms')->bindValue(':parms', $this->id_fonte)->queryOne();
          Yii::$app->db->createCommand()->insert('lista_nera', [
              'id_utente' => $post2["id"],
              'id_fonte' =>  $post["id"]
          ])->execute();

          return $arr;
        }
    }
  }
?>
