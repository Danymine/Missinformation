<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ImageForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
     public function actionIndex( ){


       return $this->render('index');
     }
}
