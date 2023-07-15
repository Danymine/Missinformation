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
use app\models\FontiForm;
use app\models\ListaNera;

class FontiController extends Controller{

  public function actionRisultato(){

    $model= new FontiForm();
    if(isset($_POST["FontiForm"])){

      $model->load(Yii::$app->request->post());
      $results = $this->getIndexFonti($model->url);

      if(!isset($results)){

        return $this->render('risultato', ['model' => $model, 'results' => "URL non raggiungibile o disabilito.", 'status' => false]);
      }
      else{

        return $this->render('risultato', ['model' => $model, 'results' => $results["results"], 'status' => true]);
      }
    }
    return $this->render('risultato', ['model' => $model]);
  }

  public function actionAggiungi($url){

    $model = new ListaNera($_COOKIE["Utente"], $url);
    $lista = $model->addFonteListanera();
    return $this->goHome();
  }

  public function actionRimuovi(){


  }

  public function actionVisualizza(){

    $post = Yii::$app->db->createCommand('SELECT id FROM utente WHERE nome=:parms')->bindValue(':parms', $_COOKIE["Utente"])->queryOne();
    $post = Yii::$app->db->createCommand('SELECT link FROM fonte, lista_nera WHERE id_utente=:parms group by link;')->bindValue(':parms', $post["id"])->queryAll();

    return $this->render('visualizza', ['lista' => $post]);
  }

  private function getIndexFonti($url_input){

     if(filter_var($url_input, FILTER_VALIDATE_URL) == true){

      /* NOTE: L'indice di attendibilità di una fonte lo vorremmo ottenere:
      Criteri
        Il sito non pubblica ripetutamente contenuti falsi: Al momento dell’analisi, il sito non pubblica ripetutamente contenuti che sono stati ritenuti chiaramente e significativamente falsi e che non sono stati corretti in modo rapido ed evidente. Al mancato rispetto di questo criterio è associato uno standard elevato. In pratica, significa che, in un dato giorno, è probabile che sul sito appaiano informazioni significativamente false. (22 punti)
        Raccoglie e presenta le informazioni in modo responsabile
        Corregge o spiega regolarmente gli errori:
        Gestisce la differenza tra notizie e opinioni in modo responsabile:
        Evita titoli ingannevoli
        Trasparenza
        Il sito dichiara chi ne è proprietario e chi lo finanzia:
        Identifica i responsabili, evidenziando eventuali conflitti di interesse:
        Il sito fornisce i nomi degli autori dei contenuti, insieme ai loro profili biografici o ai loro contatti:
      */

      // URL del sito web dell'autorità di regolamentazione o dell'organismo competente
      $urlParse = parse_url($url_input);
      $url = $urlParse["host"];


      //Posso adesso controllare i dati relativi l'URL.
      $apikey = "dea67ae1-d848-4dd8-a412-3d20164a8d80";
      $apipassword = "ba158582-80a8-4b4c-bb93-3c856891ecf7";
      $urlapi = 'https://api.xforce.ibmcloud.com/url/';
      $requestUrl = $urlapi . $url;
      $ch = curl_init();
      // Imposta le opzioni della richiesta cURL
      $options = array(
          CURLOPT_URL => $requestUrl,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER => array(
              'Authorization: Basic ' . base64_encode($apikey . ':' . $apipassword)
          )
      );

      // Imposta le opzioni della sessione cURL
      curl_setopt_array($ch, $options);
      $response = curl_exec($ch);

      // Gestisce la risposta
      if ($response) {

          curl_close($ch);
          $response = json_decode($response, true);
          $array = ["status" => true, "results" => $response];
          return $array;
      } else {

          // Si è verificato un errore nella richiesta
          $response = curl_error($ch);
          curl_close($ch);
          $array = ["status" => false, "error" => $response];
          return $array;
      }
    }
    else{

      $array = ["status" => false, "error" => "L'URL inserito non è valido."];
    }
  }
}
?>
