<?php

  namespace app\models;

  use Yii;
  use yii\base\Model;
  use FontiForm;
  use GoogleSearchResults;

  class ImageForm extends Model{

    public $url;
    public $path;
    public $indice;
    public $ordinata;

    public function rules() {
       return [
           [['url', 'ordinata'], 'required'],
       ];
     }

     public function prendifonti(){

         $query = [
           'url' => $this->url,
           'engine' => "google_lens",
           'hl' => 'it'
         ];
         $search = new GoogleSearchResults('b688484cf138380004aac7f1fc384201492f970b964e1fc4685c96cc6cda824e');
         $data = $search->get_json($query);
         $data = json_decode(json_encode($data), true);
         $arr = $data["visual_matches"];
         $array = [];
         for($i = 0; $i < count($arr); $i++){

           if( strlen($arr[$i]["title"]) < 100 && $arr[$i]["title"] != "untitled"){

             array_push($array, $arr[$i]);
           }
         }

         if( $this->ordinata == 1){

           //Lo vuole ordinato in base all'indice che assegnamo.
           return $array;
         }
         else{
          return $array;
         }
      }

      public function getIndex(){

          return rand(0, 100);
      }
  }



?>
