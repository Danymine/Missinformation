<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\RegistrazioneForm;

class RegistrazioneController extends Controller{

  public function actionSig(){

    $model = new RegistrazioneForm();
    $session = Yii::$app->session;
    if($session->isActive){

      return $this->render('sig', ['model' => $model, 'loggato'=>true]);
    }
    return $this->render('sig', ['model' => $model]);
  }
}
?>
