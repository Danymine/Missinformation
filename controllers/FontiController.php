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

class FontiController extends Controller{

  public function actionRisultato(){

    $model= new FontiForm();
    if( isset($_POST["FontiForm"]) ){

      $model->load(Yii::$app->request->post());
      $results = $model->getIndexFonti();

      if(!isset($results)){

        return $this->render('risultato', ['model' => $model, 'results' => "URL non raggiungibile o disabilito.", 'status' => false]);
      }
      else{

        return $this->render('risultato', ['model' => $model, 'results' => $results["results"], 'status' => true]);
      }
    }
    return $this->render('risultato', ['model' => $model]);
  }
}
?>
