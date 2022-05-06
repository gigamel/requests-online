<?php

use vendor\ASh\Url\UrlManager;
use vendor\ASh\Pager\Links;
use vendor\ASh\Filter\FilterForm;

$this->setTitle('Менеджер онлайн заявок');
?>
<h3>Записи клиентов</h3>

<?php $notify->accept(); ?>

<?= FilterForm::widget($filter); ?>

<?php if (count($requests) == 0): ?>
<p>ничего не найдено</p>
<?php else: ?>
<div class="table-responsive">
  <table class="table custom-table">
    <thead>
      <tr>
        <th>Имя</th>
        <th>Телефон</th>
        <th>E-mail</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($requests as $request): ?>
      <tr>
        <td><?= $request->name ?></td>
        <td><?= $request->phone ?></td>
        <td><?= $request->email ?></td>
        <td class="text-right">
          <a href="<?= UrlManager::link('request/delete&id='.$request->id) ?>"
            class="btn btn-secondary">удалить</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?= Links::widget($pagination); ?>
</div>
<?php endif; ?>
