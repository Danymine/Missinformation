<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Utente;

class SiteController extends Controller
{
  public function actionIndex()
  {
      return $this->render('index');
  }
}
