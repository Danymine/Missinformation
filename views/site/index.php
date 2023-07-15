<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
  <title>Misinformation Fight System</title>
  <style>

    .hero {
      background-image: url('https://i0.wp.com/epthinktank.eu/wp-content/uploads/2022/04/FakeNews_AdobeStock_445149207.jpeg?fit=5382%2C3588&ssl=1');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      padding: 300px 0;
      background-color: rgba(0, 0, 0, 0.3);
    }

    .hero .container {
      position: relative;
      z-index: 1;
    }

    .features {
      background-color: #e9ecef;
      padding: 80px 0;
    }

    .card {
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .mb-5 {
      margin-bottom: 5rem;
    }

    .mb-7 {
      margin-bottom: 7rem;
    }

    .btn-block {
      height: 50px;
      width: 300px;
    }

    .btn-primary {
      background-color: #8B1A1A;
      border-color: #8B1A1A;
    }

    .btn-primary:hover {
      background-color: #800000;
      border-color: #800000;
    }

    .btn-description {
      height: 80px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .navbar-light .navbar-text {

      color: black;
    }

  </style>
</head>
<body>

  <section class="hero mb-5">
    <div class="container text-center">
      <h1 class="display-4">Misinformation Fight System</h1>
      <p class="lead">Combattiamo le fake news e promuoviamo informazioni affidabili</p>
    </div>
  </section>

  <section class="features mb-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="card p-4 h-100">
            <h3 class="card-title text-center">Verifica notizia</h3>
            <p class="card-text">Utilizziamo algoritmi avanzati per valutare l'accuratezza delle notizie attraverso diversi criteri come l'analisi del testo, la verifica dei fatti e la rilevazione di manipolazioni.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card p-4 h-100">
            <h3 class="card-title text-center">Valutazione fonti</h3>
            <p class="card-text">Analizziamo la reputazione e l'accuratezza delle fonti di notizie per aiutarti a identificare quelle affidabili e di alta qualità.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card p-4 h-100">
            <h3 class="card-title text-center">Black list personale</h3>
            <p class="card-text">Gestisci una lista personalizzata di fonti di notizie non affidabili o di bassa qualità, fornendo un controllo sull'origine delle informazioni.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="mb-5">
    <div class="container text-center">
      <div class="row">
        <div class="col-md-6">
          <?php
            $url = Url::toRoute(['notizia/risultato']);
            echo "<a href=\"" . $url . "\" class=\"btn btn-primary btn-lg btn-block mb-3\">Verifica Notizia</a>";
          ?>
          <p class="btn-description">Verifica la veridicità di una notizia.</p>
        </div>
        <div class="col-md-6">
          <?php
            $url = Url::toRoute(['notizia/simile']);
            echo "<a href=\"" . $url . "\" class=\"btn btn-primary btn-lg btn-block mb-3\">Ottieni Notizia Simile</a>";
          ?>
          <p class="btn-description">Ottieni un elenco di notizie simili a quella che inserisci.</p>
        </div>
        <div class="col-md-6">
          <?php
            $url = Url::toRoute(['fonti/risultato']);
            echo "<a href=\"" . $url . "\" class=\"btn btn-primary btn-lg btn-block mb-3\">Verifica Fonte</a>";
          ?>
          <p class="btn-description">Ottieni l'indice di attendibilità di una fonte.</p>
        </div>
        <?php
          //setcookie($_COOKIE["Amministratore"], "", time()-43534);
          //setcookie($_COOKIE["Utente"], "", time()-43534);
          if(isset($_COOKIE["Utente"]) or isset($_COOKIE["Amministratore"])){

            echo "<div class=\"col-md-6\">";
            $url = Url::toRoute(['fonti/visualizza']);
            echo "<a href=\"" . $url . "\" class=\"btn btn-primary btn-lg btn-block mb-3\">Lista Nera</a><p class=\"btn-description\">Visualizza la tua lista nera.</p></div>";
          }
        ?>
      </div>
    </div>
  </section>

  <footer>
    <div class="container text-center">
      <p>&copy; 2023 Misinformation Fight System. Tutti i diritti riservati.</p>
    </div>
  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
