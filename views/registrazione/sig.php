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
  </head>
  <body>
    <?php

      if($loggato == true){

        echo "Sei già loggato";
      }
    ?>
  <section class="vh-100">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
      <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-9 col-lg-7 col-xl-6">
            <div class="card" style="border-radius: 15px;">
              <div class="card-body p-5">
                <h2 class="text-uppercase text-center mb-5">Create an account</h2>
                <?php

                $form = ActiveForm::begin([
                    'options' => [
                      'enctype' =>  "multipart/form-data",
                    ],
                    'action' => ["registrazione/sig"],
                    'method' => "POST"
                  ]);
                ?>
                    <?= $form->field($model, 'nome')->textInput()->hint('Inserisci il tuo nome'); ?>
                    <?= $form->field($model, 'cognome')->textInput()->hint('Inserisci il tuo cognome'); ?>
                    <?= $form->field($model, 'email')->textInput()->hint('Inserisci la tua email'); ?>
                    <?= $form->field($model, 'password')->textInput()->hint('Inserisci la tua password'); ?>
                    <?= Html::submitButton('Invia', ['class' => 'btn btn-primary']); ?>

                <?php
                  ActiveForm::end();
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
