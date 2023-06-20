<?php

  namespace app\models;
  use Yii;
  use yii\base\Model;
  use GoogleSearchResults;
  use Goutte\Client;
  use Symfony\Component\HttpClient\HttpClient;

  class TextForm extends Model{

    public $text;

    public function rules() {
       return [
           [['text'], 'safe'],
       ];
     }

     public function getIndex(){

      // NOTE: Utilizziamo OpenAI e li chiediamo se ha conoscenza di quell'evento.
      $apikey = "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";
      $url = 'https://api.openai.com/v1/completions';
      $data = [
          'max_tokens' => 100,
          'model' => "text-davinci-003",
          "prompt" => "Sapresti fornire un indice di attendibilità a questa affermazione? \"" . $this->text . "\" rispondi solo con una stringa contentente o Si o No"
      ];
      $headers = [
          'Authorization: Bearer ' . $apikey,
          'Content-Type: application/json',
      ];
      // Effettua la richiesta POST all'API di OpenAI
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      $response = curl_exec($ch);

      if( $response == false ){

        // Errore nella richiesta
        $error = curl_error($ch);
        curl_close($ch);
        return $error;
      }
      else{

        curl_close($ch);
        $response = json_decode($response, true);
        $textResponse = trim($response["choices"][0]["text"]);

        if( $textResponse == "No" ){

          //Open AI non dispone delle informazioni necessarie per poter calcolare il proprio indice. Quindi returno un indice assegnato casualmente, dovrebbe essere prodotto da un altra API ma non abbiamo trovato altre soluzioni.
          return rand(0, 100);
        }
        else{

          //Open Ai dispone delle informazioni.
          $data["prompt"] = "Valuta quanto la seguente affermazione corrisponde al vero assegnando un punteggio da 0 a 100." . $this->text . "Rispondi solo con il punteggio.";
          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
          $response = curl_exec($ch);
          if( $response == false ){

            // Errore nella richiesta
            $error = curl_error($ch);
            curl_close($ch);
            return $error;
          }
          else{

            curl_close($ch);
            $response = json_decode($response, true);
            $indexOpen = (int)trim($response["choices"][0]["text"]);
            return $indexOpen;
          }

        }
      }
    }

    public function getFonti(){

      if(filter_var($this->text, FILTER_VALIDATE_URL) == false){

        $query = [
          'q' => $this->text,
          'engine' => "google",
          'hl' => 'it',
          'gl' => 'it',
          'tbm' => 'nws',
          'num' => '40'
        ];
        return $this->queryFonti($query);
      }
      else{

          $client = new Client(HttpClient::create(['timeout' => 60]));
          $crawler = $client->request("GET", $this->text);
          $titles = $crawler->filter("h1")->each(function ($node) {
          	return $node->text();
          });

          $query = [
            'q' => $titles,
            'engine' => "google",
            'hl' => 'it',
            'gl' => 'it',
            'tbm' => 'nws',
            'num' => '40'
          ];

          return $this->queryFonti($query);
      }
    }

    private function queryFonti($query){

      $search = new GoogleSearchResults('b688484cf138380004aac7f1fc384201492f970b964e1fc4685c96cc6cda824e');
      $data = $search->get_json($query);
      $data = json_decode(json_encode($data), true);
      $arr = [];
      if( !isset($data["error"]) ){

        $arr["results"] = $data["news_results"];
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
}


?>
