<?php
/*
Se decidiamo di visualizzare il risulato sulla stessa pagina dell'imput:
Creare una vista in in image e creare i controller che la gestiscotno
*/
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Notizia;
use app\models\Segnalazione;
use GuzzleHttp\Client;
use Goutte\Client as Prova;
use GoogleSearchResults;
use yii\helpers\Url;


class NotiziaController extends Controller{

  public function actionRisultato(){

    $model = new Notizia(1);
    if(isset($_POST["Notizia"])){

      $model->load(Yii::$app->request->post());
      if($model->tipo == 1){

        // NOTE: IndiceAttendibilità di semplice TESTO o di un articolo inserito attraverso URL.
        if(filter_var($model->testo, FILTER_VALIDATE_URL) == false){    //Verifico se l'utente ha inserito un URL o semplice TESTO.

          $index = $this->getIndexText($model->testo);  //Semplice TESTO procedo a calcolare l'indice di attendibilità.
          return $this->render('risultato', [
              'model' => $model,
              'index' => $index
            ]);
        }
        else{

          $client = new Prova();
          $crawler = $client->request("GET", $model->testo);
          $titles = $crawler->filter("h1")->each(function ($node) {       //URL procedo prima a recuperare l'informazione di cui ottenere l'indice di attendibilità
          	return $node->text();
          });
          $index = $this->getIndexText($titles[0]);     //Adesso che ho l'informazione da verificare vado a calcolare l'indice di attendibilià.
          return $this->render('risultato', [
              'model' => $model,
              'index' => $index
            ]);
        }
      }
      elseif ($model->tipo == 2) {

        // NOTE: IndiceAttendibilità di una IMMAGINE inserita tramite URL molto probabilmente butteremo l'idea di poterla inserire dal PC.
        if(filter_var($model->testo, FILTER_VALIDATE_URL) == true){

          $client = new Client();
          $crawler = $client->request('HEAD', $model->testo);
          $contentType = $crawler->getHeaders();
          $type = $contentType["Content-Type"][0];
          if(strpos($type, "image") !== false){
            $index = $this->getIndexImage($model->testo);
            return $this->render('risultato', [
                'model' => $model,
                'index' => $index
              ]);
          }
          else{

            return $this->render('risultato', [
                'model' => $model,
                'index' => "Non hai inserito un URL valido."
              ]);
          }
        }
        else{

            return $this->render('risultato', [
                'model' => $model,
                'index' => "Non hai inserito un URL bensì del semplice testo. Si prega di inserire un URL valido inerente un'immagine."
              ]);
        }
      }
      elseif ($model->tipo == 3) {

        // NOTE: IndiceAttendibilità di un VIDEO inserito tramite URL molto probabilmente butteremo l'idea di poterlo inserire dal PC.
        if(filter_var($model->testo, FILTER_VALIDATE_URL) == true){

          //Devo fare qualcosa per calcolare l'IndiceAttendibilità
          $index = $this->getIndexVideo($model->testo);
          return $this->render('risultato', [
              'model' => $model,
              'index' => $index
            ]);
        }
        else{

            return $this->render('risultato', [
                'model' => $model,
                'index' => "Non hai inserito un URL bensì del semplice testo. Si prega di inserire un URL valido inerente un'video."
              ]);
        }
      }
      else{

        // NOTE: IndiceAttendibilità di un AUDIO inserito tramite URL molto probabilmente butteremo l'idea di poterlo inserire dal PC.
        if(filter_var($model->testo, FILTER_VALIDATE_URL) == true){

          //Devo fare qualcosa per calcolare l'IndiceAttendibilità
          $index = $this->getIndexAudio($model->testo);
          return $this->render('risultato', [
              'model' => $model,
              'index' => $index
            ]);
        }
        else{

            return $this->render('risultato', [
                'model' => $model,
                'index' => "Non hai inserito un URL bensì del semplice testo. Si prega di inserire un URL valido inerente un'audio."
              ]);
        }
      }
    }
    else{

      return $this->render('risultato', [
        'model' => $model
        ]);
    }
  }

  public function actionSimile(){

    //NotiziaSimile
    $model = new Notizia(1);
    if(isset($_POST["Notizia"])){

      $model->load(Yii::$app->request->post());
      if($model->tipo == 1){

        // NOTE: NotiziaSimile di semplice TESTO o di un articolo inserito attraverso URL.
        if(filter_var($model->testo, FILTER_VALIDATE_URL) == false){    //Verifico se l'utente ha inserito un URL o semplice TESTO.

          $query = [
            'q' => $model->testo,
            'engine' => "google",
            'hl' => 'it',
            'gl' => 'it',
            'tbm' => 'nws',
            'num' => '40'
          ];
          $results = $this->queryFonti($query, "news_results");
          if($results["error"] == false){
            return $this->render('simile', [
                'model' => $model,
                'elements' => $results["results"],
                'state_request' => true
              ]);
          }
          else{
            return $this->render('simile', [
                'model' => $model,
                'elements' => $results["message_error"],
                'state_request' => false
              ]);
          }
        }
        else{

          $client = new Client();
          $crawler = $client->request('HEAD', $model->testo);
          $contentType = $crawler->getHeaders();
          $type = $contentType["Content-Type"][0];
          if(strpos($type, "html") !== false){

            $client = new Prova();
            $crawler = $client->request("GET", $model->testo);
            $titles = $crawler->filter("h1")->each(function ($node) {       //URL procedo prima a recuperare l'informazione di cui ottenere l'indice di attendibilità
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

            $results = $this->queryFonti($query, "news_results");
            if(!isset($array["results"])){

              return $this->render('simile', [
                  'model' => $model,
                  'elements' => $results["results"],
                  'state_request' => true
                ]);
            }
            else{

              return $this->render('simile', [
                  'model' => $model,
                  'elements' => $results["message_error"],
                  'state_request' => false
                ]);
            }
          }
          else{

            return $this->render('simile', [
                'model' => $model,
                'elements' => "Inserisci un URL di un articolo.",
                'state_request' => false
              ]);
          }
        }
      }
      else if($model->tipo == 2){

        // NOTE: NotiziaSimile di un immagine inserita attraverso URL.
        if(filter_var($model->testo, FILTER_VALIDATE_URL) == true){

          $client = new Client();
          $crawler = $client->request('HEAD', $model->testo);
          $contentType = $crawler->getHeaders();
          $type = $contentType["Content-Type"][0];
          if(strpos($type, "image") !== false){

            $query = [
              'url' => $model->testo,
              'engine' => "google_lens",
              'hl' => 'it'
            ];
            $array = $this->queryFonti($query, "visual_matches");
            $result = [];
            if(!isset($array["results"])){

              return $this->render('simile', [
                  'model' => $model,
                  'elements' => $array["message_error"],
                  'state_request' => false
                ]);
            }

            $arr = $array["results"];

            for($i = 0; $i < count($arr); $i++){

              if( strlen($arr[$i]["title"]) < 100 && $arr[$i]["title"] != "untitled"){

                array_push($result, $arr[$i]);
              }
            }

            return $this->render('simile', [
                'model' => $model,
                'elements' => $result,
                'state_request' => true
              ]);
          }
          else{

            return $this->render('simile', [
                'model' => $model,
                'elements' => "Inserisci un URL di una immagine.",
                'state_request' => false
              ]);
          }
        }
        else{

          //Trovare un modo per stampare un errore.
          return $this->render('simile', [
              'model' => $model,
              'elements' => "Inserisci un URL valido.",
              'state_request' => false
            ]);
        }
      }
      else if($model->tipo == 3){

        if(filter_var($model->testo, FILTER_VALIDATE_URL) == true){

          $client = new Client();
          $crawler = $client->request('HEAD', $model->testo);
          $contentType = $crawler->getHeaders();
          $type = $contentType["Content-Type"][0];
          if(strpos($type, "html") !== false){

             $client = new Prova();
             $crawler = $client->request("GET", $model->testo);
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

             $results = $this->queryFonti($query, "video_results");
             if(!isset($array["results"])){
               return $this->render('simile', ['elements' => $results["results"], 'model' => $model, "state_request" => true]);
             }
             else{

               return $this->render('simile', ['elements' => $results["message_error"], 'model' => $model, "state_request" => false]);
             }
          }
          else{

            return $this->render('simile', [
                'model' => $model,
                'elements' => "Inserisci un URL di un video.",
                'state_request' => false
              ]);
          }
        }
        else{

          return $this->render('simile', ['elements' => "Inserisci un URL valido.", 'model' => $model, "state_request" => false]);
        }
      }
    }
    else{

      return $this->render('simile', [
        'model' => $model
        ]);
    }
  }

  public function actionTest($link){

    $model = new Notizia(1);
    $client = new Prova();
    $crawler = $client->request("GET", $link);
    $titles = $crawler->filter("h1")->each(function ($node) {       //URL procedo prima a recuperare l'informazione di cui ottenere l'indice di attendibilità
      return $node->text();
    });
    $titlesvideo = $crawler->filter("title")->each(function ($node) {       //URL procedo prima a recuperare l'informazione di cui ottenere l'indice di attendibilità
      return $node->text();
    });

    if(empty($titles)){

      $testo = $titlesvideo[0];
    }
    else{

      $testo = $titles[0];
    }
    if($testo != "Access Denied"){

      $apikey = "API-KEY BY CHATGPT HERE";
      $url = 'https://api.openai.com/v1/completions';
      $data = [
          'max_tokens' => 100,
          'model' => "text-davinci-003",
          "prompt" => "Fornisci solo l'argomento principale di questo testo: " . $testo
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

      $response = json_decode($response, true);
      $textResponse = trim($response["choices"][0]["text"]);

      Yii::$app->db->createCommand()->insert('notizia', [
          'link' => $link,
          'argomento' => $textResponse,
          'tipo' => 'testo'
      ])->execute();
      $post = Yii::$app->db->createCommand('SELECT id FROM notizia WHERE link=:parms')->bindValue(':parms', $link)->queryOne();
      if(empty($post)){

        return $this->render('simile', [
            'model' => $model,
            "message_return" => "L'invio della segnalazione è fallito.",
            "request" => false
          ]);
      }
      else{

        $post2 = Yii::$app->db->createCommand('SELECT id FROM utente WHERE nome=:parms')->bindValue(':parms', $_COOKIE["Utente"])->queryOne();
        if(empty($post2)){

          return $this->render('simile', [
              'model' => $model,
              "message_return" => "L'invio della segnalazione è fallito.",
              "request" => false
            ]);
        }
        else{

          Yii::$app->db->createCommand()->insert('segnalazione', [
              'id_utente' => $post2["id"],
              'id_notizia' => $post["id"]
          ])->execute();
          return $this->render('simile', [
              'model' => $model,
              "message_return" => "L'invio della segnalazione è riuscito.",
              "request" => true
            ]);
        }
      }
    }
    else{

      return $this->render('simile', [
          'model' => $model,
          "message_return" => "L'invio della segnalazione è fallito.",
          "request" => false
        ]);
    }

  }

  private function OrdinataSimile(){

  }

  private function getIndexText($text){

    // NOTE: Utilizziamo OpenAI e li chiediamo se ha conoscenza di quell'evento.
    $apikey = "API-KEY BY CHATGPT HERE";
    $url = 'https://api.openai.com/v1/completions';
    $data = [
        'max_tokens' => 100,
        'model' => "text-davinci-003",
        "prompt" => "Sapresti fornire un indice di attendibilità a questa affermazione? \"" . $text . "\" rispondi solo con una stringa contentente o Si o No"
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
        $data["prompt"] = "Valuta quanto la seguente affermazione corrisponde al vero assegnando un punteggio da 0 a 100." . $text . "Rispondi solo con il punteggio.";
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

  private function getIndexImage($url){

      return rand(0, 100);
  }

  private function getIndexVideo($url){

      return rand(0, 100);
  }

  private function getIndexAudio($url){

      return rand(0, 100);
  }

  private function queryFonti($query, $use){

    $search = new GoogleSearchResults('API-KEY GOOGLE SEARCH HERE');
    $data = $search->get_json($query);
    $data = json_decode(json_encode($data), true);
    if(isset($_COOKIE["Utente"])){

      $post = Yii::$app->db->createCommand('SELECT id FROM utente WHERE nome=:parms')->bindValue(':parms', $_COOKIE["Utente"])->queryOne();
      $post = Yii::$app->db->createCommand('SELECT link FROM fonte, lista_nera WHERE id_utente=:parms group by link;')->bindValue(':parms', $post["id"])->queryAll();
      if(!isset($data["error"]) ){

        $arr = [
          "results" => [],
          "error" => false
        ];

        for($i = 0; $i < count($data[$use]); $i++){

          $bol = false;
          $urlParse = parse_url($data[$use][$i]["link"]);
          $url_fonte = $urlParse["host"];

          for($j = 0; $j < count($post) and $bol != true; $j++){

            if($url_fonte == $post[$j]["link"]){

              $bol = true;
            }
          }
          if($bol != true){

            array_push($arr["results"], $data[$use][$i]);
          }
        }
        return $arr;
      }
      else{

          $arr = [
            "results" => NULL,
            "error" => true,
            "message_error" => $data["error"]
          ];
         return $arr;
      }
    }
    else{

      if(!isset($data["error"]) ){

        $arr = [
          "results" => [],
          "error" => false
        ];
        $arr["results"] = $data[$use];
        $arr["error"] = false;
        return $arr;
      }
      else{

        $arr["result"] = NULL;
        $arr["error"] = true;
        $arr["message_error"] = $data["error"];
      }
    }
  }
}


?>
