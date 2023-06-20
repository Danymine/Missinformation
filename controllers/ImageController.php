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
use app\models\ImageForm;

class ImageController extends Controller{

  public function actionFonti(){

      $model = new ImageForm();
      if(isset($_POST["ImageForm"])){
        $model->load(Yii::$app->request->post());
      /*
        NOTE:
        Acquisisci i dati inseriti nel form e inviati tramite metodo POST
        Questi dati possono essere:
          1)URL dell'immagine da elaborare(deve rappresentare esattamente l'immagine non il "sito" in cui è contenuta).
          2)Il file immagine.
        END NOTE
      */

      /*
        NON GESTIBILE PER ADESSO
        NOTE: Inizio prova per scaricare l'immagine
        $img="file-inserito.jpg";
        file_put_contents($img, file_get_contents($model->url));
        /*Fine scaricare immaggine. Considerazioni:
          1)Funziona
          2)Non è ottimabile preferebile utilizzare cURL
          END NOTE
      */
        $fonti = $model->prendifonti();
        return $this->render('fonti', ['elements' => $fonti, 'model' => $model]);
      }
      return $this->render('fonti', ['model' => $model]);
    }
  public function actionRisultato(){

        $model = new ImageForm();
        if(isset($_POST["ImageForm"])){
          $model->load(Yii::$app->request->post());
          $index = $model->getIndex();
          return $this->render('risultato', ['index' => $index, 'model' => $model]);
        }
        return $this->render('risultato', ['model' => $model]);
      }
}


?>
