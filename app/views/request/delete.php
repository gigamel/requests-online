<?php

use vendor\ASh\Url\UrlManager;

$this->setTitle('Удаление заявки');
?>
<h3>Удалить заявку #<?= $request->id ?>[<?= $request->name ?>]?</h3>
<form method="POST" action="">
  <a href="<?= UrlManager::link('request/manager'); ?>"
    class="btn btn-secondary">Нет</a>
  <button type="submit" name="confirm" class="btn btn-primary">Да</button>
</form>
