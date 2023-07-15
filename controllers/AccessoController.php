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
use app\models\Utente;
use app\models\Amministratore;

class AccessoController extends Controller{

  public function actionLogin()
  {
    if(!(isset($_COOKIE["Utente"]) or isset($_COOKIE["Amministratore"])) ){
      //Se l'utente ha già effettuato l'accesso non deve poter riaccedere questo lo faremo attraverso un cookie
      $model = new Utente();
      if(isset($_POST["Utente"])){

          $model->load(Yii::$app->request->post());
          $admin= new Amministratore($model);
          if($admin->isAmministratore() == true){


            setcookie("Amministratore", $admin->email, time() + (3600));
            return $this->goHome();
          }
          else{

            $post = Yii::$app->db->createCommand('SELECT id, nome FROM utente WHERE email=:parms and password=:passw')->bindValue(':parms', $model->email)->bindValue(':passw', md5($model->password))->queryOne();
            if(empty($post)){

              return $this->render('login', [
                  'string' => "Non è stato trovato un account associato a queste credenziali.",
                  'model' => $model
              ]);
            }
            else{
              setcookie("Utente", $post["nome"], time() + (3600));
              return $this->goHome();
            }
          }
      }
      else{

        return $this->render('login', [
            'model' => $model
        ]);
      }
    }
    else{

      return $this->goHome();
    }
  }
  public function actionLogout()
  {

    if(isset($_COOKIE["Utente"])){

      setcookie("Utente", '', time() - (86400 * 30));
      return $this->goHome();
    }

    setcookie("Amministratore", '', time() - (86400 * 30));
    return $this->goHome();
  }

  public function actionRegistrazione()
  {
    $model = new Utente();
    if(isset($_POST["Utente"])){

      $model->load(Yii::$app->request->post());
      if($model->password === $model->conferma){

        //Le due password inserite coindiono. Ora controlliamo che non sia già presente lo stesso Username e Email
        $post = Yii::$app->db->createCommand('SELECT email FROM utente WHERE email=:parms')->bindValue(':parms', $model->email)->queryOne();
        if(empty($post)){

          Yii::$app->db->createCommand()->insert('utente', [
              'nome' => $model->username,
              'email' => $model->email,
              'password' => md5($model->password)
          ])->execute();
          return $this->render('login', [
              'model' => $model
          ]);
        }
        else{

          return $this->render('registrazione', [
              'errore' => "Esiste già un account associato a questa Email. Effettua il Login.",
              'model' => $model
          ]);
        }
      }
      else{

        return $this->render('registrazione', [
            'model' => $model,
            'errore' => "Password non coincidono"
        ]);
      }
      //Controlla nel DB se esiste un utente con queste credenziali
      return $this->goHome();
    }
    else{

      return $this->render('registrazione', [
          'model' => $model
      ]);
    }
  }
}
