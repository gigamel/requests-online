<?php
$this->title = 'Рос Запись - приёмная онлайн»';
?>
<h3>Записаться на приём</h3>

<?php $notify->accept(); ?>

<p>вы можете прямо сейчас, заполнив поля:</p>
<form method="POST" action="" autocomplete="off">
  <div class="form-group">
    <input type="text" name="Client[name]" class="form-control"
      value="<?= $model->name ?>" placeholder="имя">
  </div>
  <div class="form-group">
    <input type="text" name="Client[phone]" class="form-control regex_phone"
      value="<?= $model->phone ?>" placeholder="телефон">
  </div>
  <div class="form-group">
    <input type="text" name="Client[email]" class="form-control"
      value="<?= $model->email ?>" placeholder="e-mail">
  </div>
  <p>и после чего, нажав на кнопку</p>
  <button type="submit" class="btn btn-primary">Записаться</button>
</form>