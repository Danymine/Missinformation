<?php

  namespace app\models;

  use Yii;
  use yii\base\Model;
  use FontiForm;
  use GoogleSearchResults;
  use Goutte\Client;
  use Symfony\Component\HttpClient\HttpClient;

  class VideoForm extends Model{

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

      if(filter_var($this->url, FILTER_VALIDATE_URL) == true){

         $client = new Client(HttpClient::create(['timeout' => 60]));
         $crawler = $client->request("GET", $this->url);
         $titles = $crawler->filter("title")->each(function ($node) {
          return $node->text();
         });

         $query = [
           'q' => $titles,
           'engine' => "google_videos",
           'hl' => 'it',
           'gl' => 'it',
           'tbm' => 'nws',
           'num' => '40'
         ];

         $search = new GoogleSearchResults('b688484cf138380004aac7f1fc384201492f970b964e1fc4685c96cc6cda824e');
         $data = $search->get_json($query);
         $data = json_decode(json_encode($data), true);
         $arr = [];

         if(!isset($data["error"]) ){

           $arr["results"] = $data["video_results"];
           $arr["error"] = false;
           return $arr;
         }
         else{
            $arr["result"] = NULL;
            $arr["error"] = true;
            $arr["message_error"] = $data["error"];
            return $arr;
        }
      }
      else{

        return ["error" => true];
      }
  }

      public function getIndex(){

          return rand(0, 100);
      }
  }



?>
