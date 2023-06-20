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
use app\models\TextForm;

class TextController extends Controller{

  public function actionRisultato(){

    $model = new TextForm();
    if(isset($_POST["TextForm"])){

      $model->load(Yii::$app->request->post()); //Gestire la possibilità che load non funzioni.
      $index = $model->getIndex();
      return $this->render('risultato', [
            'model' => $model,
            'index' => $index,
        ]);

    }
    else{
      return $this->render('risultato', [
          'model' => $model
        ]);
    }
  }
  public function actionFonti(){
    
    $model = new TextForm();
    if(isset($_POST["TextForm"])){

      $model->load(Yii::$app->request->post());
      $fonti = $model->getFonti();
      if($fonti["error"] == false){
        return $this->render('fonti', [
            'model' => $model,
            'elements' => $fonti,
            'state_request' => true
          ]);
      }
      else{
        return $this->render('fonti', [
            'model' => $model,
            'elements' => $fonti,
            'state_request' => false
          ]);
      }
    }
    return $this->render('fonti', [
        'model' => $model
      ]);
  }
}
?>
