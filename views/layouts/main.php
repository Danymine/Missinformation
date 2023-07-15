<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<header id="header">
  <nav class="container navbar navbar-expand-md navbar-light bg-light">
    <?php
    $url =  Url::home(true);
    echo "<a class=\"navbar-brand\" href=\"". $url . "\">Missinformation</a>";
    ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <?php
        $url =  Url::home(true);
        echo "<li class=\"nav-item active\">
                <a class=\"nav-link\" href=\"" . $url . "\">Home</a>
              </li>";
        ?>
        <li class="nav-item">
          <a class="nav-link" href="">Informazioni</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Servizi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contatti</a>
        </li>
        <?php
          if(isset($_COOKIE["Utente"]) or isset($_COOKIE["Amministratore"])){

            if(isset($_COOKIE["Utente"])){

              $var = $_COOKIE["Utente"];
            }
            else{

              $var = $_COOKIE["Amministratore"];
            }
            echo "<span class=\"navbar-text\">Bentornato "
                    . $var .
                  "</span>";
            $url = Url::toRoute(['accesso/logout']);
            echo "<li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"" . $url . "\">Esci</a>
                  </li>";
          }
          else{

            $url = Url::toRoute(['accesso/login']);
            echo "<li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"" . $url . "\">Accedi</a>
                  </li>";
            $url = Url::toRoute(['accesso/registrazione']);
            echo "<li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"" . $url . "\">Registrati</a>
                  </li>";
          }
        ?>
      </ul>
    </div>
  </nav>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
