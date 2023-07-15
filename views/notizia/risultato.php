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
    <style media="screen">
        :root {
        --gradient: linear-gradient(to left top, #DD2476 10%, #FF512F 90%) !important;
        }

        .col{

          margin-bottom: 2rem;
        }

        .btn {
        border: 5px solid #0200ff8a;
        border-image-slice: 1;
        color: white;
        font-size: 18px;
        border-radius: 15px;
        text-decoration: none;
        transition: all .4s ease;
        }

        .btn:hover, .btn:focus {
            background-color: blue;
            color: white;
        }

        a{

          text-decoration: none;
          color: blue;
        }
        .card-title{

          color: black;
        }
    </style>
  </head>

  <body>
    <h2>Questo è Notizia</h2>
    <?php

    $form = ActiveForm::begin([
        'options' => [
          'enctype' =>  "multipart/form-data",
        ],
        'action' => ["notizia/risultato"],
        'method' => "POST"
      ]);
    ?>
        <?= $form->field($model, 'testo')->textInput()->hint('Inserisci la notizia'); ?>
        <?= $form->field($model, 'tipo')->dropdownList([
            1 => 'Testo',
            2 => 'Immagine',
            3 => 'Video',
            4 => 'Audio'
        ],
        ['prompt'=>'Seleziona il tipo della notizia']); ?>
        <?= Html::submitButton('Invia', ['class' => 'btn btn-primary']); ?>

    <?php
      ActiveForm::end();

    ?>

    <?php
      if(isset($_POST["Notizia"])){
        echo "<h3>" . $index . "</h3>";
      }

    ?>
  </body>
</html>
