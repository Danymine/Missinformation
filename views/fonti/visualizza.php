<?php

/** @var yii\web\View $this */


/*LE WIEWS SONO RIFERIRE AL CONTROLLER CHE LE GESTISCE*/

use yii\helpers\html;
use yii\widgets\ActiveForm;

$title = "My Yii Application";
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
    <h2>Siamo in Visualizza Lista</h2>
    <?php
      var_dump( $lista);
    ?>
  </body>
</html>
