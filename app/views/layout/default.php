<?php
use vendor\ASh\Url\UrlManager;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?= $this->getTitle(); ?></title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
  </head>
  <body>
    <div class="header">
      <div class="container">
        <div class="row">
          <div class="col">
            <a href="/" class="logo">РосЗапись</a>
          </div>
          <div class="col text-right">
            <a href="<?= UrlManager::link('request/manager'); ?>"
              class="btn btn-secondary">Менеджер записей</a>
          </div>
        </div>
      </div>
    </div>
    <div class="main">
      <div class="container">
        <div class="row">
          <div class="col">
            <?= $CONTENT_VIEW ?>
          </div>
        </div>
      </div>
    </div>
    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="col">
            <hr>
            <p class="text-muted font-italic my-4">Created by Aleksey Sh.</p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
