<?php
  use yii\helpers\html;
  use yii\widgets\ActiveForm;

  $title = "My Yii Application Text";

?>
<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <style media="screen">
      *{
        font-family: 'Roboto', sans-serif;
      }
     .list-group{

       margin-top: 1em;
     }
     .list-group-item{

       margin-bottom: 1em;
       border: 0;
     }
    </style>
  </head>

  <body>
    <h2>Questo è text fonti</h2>
    <?php

    $form = ActiveForm::begin([
        'options' => [
          'enctype' =>  "multipart/form-data",
        ],
        'action' => ["text/fonti"],
        'method' => "POST"
      ]);
    ?>
        <?= $form->field($model, 'text')->textInput(); ?>
        <?= Html::submitButton('Invia', ['class' => 'btn btn-primary']); ?>

    <?php
      ActiveForm::end();
    ?>
    <?php
      if(isset($_POST["TextForm"])){

        if( $state_request == true){

          echo "<div class=\"list-group\">";
          for($i = 0; $i < count($elements["results"]); $i++){
            echo "<a href=\"" . $elements["results"][$i]["link"] . "\"class=\"list-group-item flex-column align-items-start\" target=\"_blank\">
             <div class=\"d-flex w-100 justify-content-between\">
               <h4 class=\"mb-1\">" . $elements["results"][$i]["title"] . "</h4>
               <small>" . $elements["results"][$i]["date"] . "</small>
             </div>
             <p class=\"mb-1\">" . $elements["results"][$i]["source"] . "</p>
             <small>" . $elements["results"][$i]["link"] . "</small>";
             echo "<hr/>";
          }
          echo "</div>";
        }
        else{

          echo $elements["message_error"];
        }

    }

    ?>
  </body>
</html>
