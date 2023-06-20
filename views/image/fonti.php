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
    <h2>Siamo in FONTI</h2>
    <?php

    $form = ActiveForm::begin([
        'options' => [
          'enctype' =>  "multipart/form-data",
        ],
        'action' => ["image/fonti"],
        'method' => "POST"
      ]);
    ?>
        <?= $form->field($model, 'url')->textInput()->hint("Inserisci l'url dell'immagine") ?>
        <?= $form->field($model, 'ordinata')->radioList([1 => 'Ordinata', 2 => 'Non Ordinata'])->hint("Ordinata le fonti in base all'indece di affidabilità che li calcoleremo"); ?>
        <?= Html::submitButton('Invia', ['class' => 'btn btn-primary']); ?>

    <?php
      ActiveForm::end();
    ?>
    <?php
      if(isset($_POST["ImageForm"])){
        echo "<div class=\"container mx-auto mt-4\">
                <div class=\"row\">";
        for($i = 0; $i < count($elements); $i++){
          echo "  <div class=\"col\">
                    <a href=\"
                 " . $elements[$i]["link"] . "\">
                      <div class=\"card h-100 \" style=\"width: 18rem;\">
                        <img class=\"card-img-top\" src=\"
                 " .     $elements[$i]["thumbnail"]  . " \" alt=\"Card image cap\">
                        <div class=\"card-body\">
                          <h5 class=\"card-title\">
                 " .       $elements[$i]["title"] . "</h5>
                          <h6 class=\"card-source\">
                 " .       $elements[$i]["source"] . "</h6>
                          <img src=\"
                 " .       $elements[$i]["source_icon"] . "\" alt=\"Card image source\">
                        </div>
                      </div>
                      </a>
                    </div>

               "
               ;
        }
        echo "  </div>
              </div>
        ";
      }
    ?>


<!--
    <script>
        var form = document.getElementById('uploadForm');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Impedisce l'invio del modulo

            var fileInput = document.getElementById('fileInput');
            var file = fileInput.files[0];
            var urlInput = document.getElementById('urlInput');
            var url = urlInput.value;

            if (file) {

                var NomeTipo = file.type;
                console.log(NomeTipo);
                if( NomeTipo == "image/png" || NomeTipo == "image/jpg" || NomeTipo == "image/jpeg"){

                  alert("Formato valido", + NomeTipo);
                }
                else{

                  alert("Formato Non Valido", + NomeTipo);
                }
              } else if (url) {
                  // URL fornito, eseguire il processo di verifica con l'URL

                  // Esempio: Visualizzazione dell'URL in un avviso
                  alert("URL del file:\n\n" + url);
              } else {
                  // Non è stato fornito alcun file o URL, visualizzare un messaggio di errore
                  alert("Seleziona un file da caricare o inserisci un URL.");
              }
        });
    </script>
  -->
  </body>
</html>
