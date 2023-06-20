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
use app\models\VideoForm;

class VideoController extends Controller{

  public function actionFonti(){

      $model = new VideoForm();
      if(isset($_POST["VideoForm"])){
        $model->load(Yii::$app->request->post());
        $fonti = $model->prendifonti();
        if($fonti["error"] == false){

          return $this->render('fonti', ['elements' => $fonti["results"], 'model' => $model, "status" => true]);
        }
        else{

          return $this->render('fonti', ['elements' => "Inserisci un Link Valido", 'model' => $model, "status" => false]);
        }
      }
      return $this->render('fonti', ['model' => $model]);
  }

  public function actionRisultato(){

        $model = new VideoForm();
        if(isset($_POST["VideoForm"])){
          $model->load(Yii::$app->request->post());
          $index = $model->getIndex();
          return $this->render('risultato', ['index' => $index, 'model' => $model]);
        }
        return $this->render('risultato', ['model' => $model]);
      }
}
