<?php
  use yii\helpers\html;
  use yii\widgets\ActiveForm;
  use yii\helpers\Url;

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

     }
    </style>
  </head>

  <body>
    <h1>Questo è text fonti</h1>
    <?php
    if(isset($request)){

      echo "<small style=\"color: red\">" . $message_return . "</small>";
    }
    $form = ActiveForm::begin([
        'options' => [
          'enctype' =>  "multipart/form-data",
        ],
        'action' => ["notizia/simile"],
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
        if($state_request == false){

          echo $elements;
        }
        else{

          if($model->tipo == 1){

            if($state_request == true){

              echo "<div class=\"list-group\">";
              for($i = 0; $i < count($elements); $i++){

                echo "<a href=\"" . $elements[$i]["link"] . "\"class=\"list-group-item flex-column align-items-start\" target=\"_blank\">
                 <div class=\"d-flex w-100 justify-content-between\">
                   <h4 class=\"mb-1\">" . $elements[$i]["title"] . "</h4>
                   <small>" . $elements[$i]["date"] . "</small>
                 </div>
                 <p class=\"mb-1\">" . $elements[$i]["source"] . "</p>
                 <small>" . $elements[$i]["link"] . "</small></a>";
                 if(isset($_COOKIE["Utente"])){
                   $url1 = Url::toRoute(['notizia/test', 'link' => $elements[$i]["link"]]);
                   echo "<div class=\"container\"><a href=\"" .$url1 . "\" style=\"float: right\">Segnala</a></div>";
                   $urlParse = parse_url($elements[$i]["link"]);
                   $url_fonte = $urlParse["host"];
                   $url2 = Url::toRoute(['fonti/aggiungi', 'url' => $url_fonte]);
                   echo "<div class=\"container\"><a href=\"" . $url2 . "\" style=\"float: right\">Blocca Fonte</a></div>";
                 }
                 echo "<hr/>";
              }
              echo "</div>";

            }
          }
          else if($model->tipo == 2){

              echo "<div class=\"container mx-auto mt-4\">
                      <div class=\"row\">";
              for($i = 0; $i < count($elements); $i++){
                echo "  <div class=\"col\">
                          <a href=\"
                       " . $elements[$i]["link"] . "\">
                            <div class=\"card \" style=\"width: 18rem;\">
                              <img class=\"card-img-top\" src=\"
                       " .     $elements[$i]["thumbnail"]  . " \" alt=\"Card image cap\">
                              <div class=\"card-body\">
                                <h5 class=\"card-title\">
                       " .       $elements[$i]["title"] . "</h5></a>
                                <h6 class=\"card-source\">
                       " .       $elements[$i]["source"] . "</h6>
                                <img src=\"
                       " .       $elements[$i]["source_icon"] . "\" alt=\"Card image source\">";
                       if(isset($_COOKIE["Utente"])){
                         $url = Url::toRoute(['notizia/test', 'link' => $elements[$i]["link"]]);
                         echo "<div class=\"container clearfix\"><a href=\"" .$url . "\" style=\"float: right\">Segnala</a></div>";
                         $urlParse = parse_url($elements[$i]["link"]);
                         $url_fonte = $urlParse["host"];
                         $url2 = Url::toRoute(['fonti/aggiungi', 'url' => $url_fonte]);
                         echo "<div class=\"container\"><a href=\"" . $url2 . "\" style=\"float: right\">Blocca Fonte</a></div>";
                       }
                       echo "
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
          else if($model->tipo == 3){

            echo "<div class=\"container mx-auto mt-4\">
                    <div class=\"row\">";
            for($i = 0; $i < count($elements); $i++){
              echo "<div class=\"col\">
                        <a href=\"
                     " . $elements[$i]["link"] . "\">
                          <div class=\"card h-100 \" style=\"width: 18rem;\">
                            <image src=\" " . $elements[$i]["thumbnail"] . "\">
                            <div class=\"card-body\">
                              <h5 class=\"card-title\">
                     " .       $elements[$i]["title"] . "</h5>
                               <small>
                      " .       $elements[$i]["link"] . "</small>
                      ";
                      if(isset($_COOKIE["Utente
                      "])){
                        $url = Url::toRoute(['notizia/test', 'link' => $elements[$i]["link"]]);
                        echo "<div class=\"container clearfix\"><a href=\"" .$url . "\" style=\"float: right\">Segnala</a></div>";
                        $urlParse = parse_url($elements[$i]["link"]);
                        $url_fonte = $urlParse["host"];
                        $url2 = Url::toRoute(['fonti/aggiungi', 'url' => $url_fonte]);
                        echo "<div class=\"container\"><a href=\"" . $url2 . "\" style=\"float: right\">Blocca Fonte</a></div>";
                      }
                      echo "
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
        }
      }

    ?>
  </body>
</html>
