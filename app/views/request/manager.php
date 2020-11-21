<?php
use vendor\ASh\Url\UrlManager;
use vendor\ASh\Pager\Links;

$this->title = 'Менеджер онлайн заявок';
?>
<h3>Записи клиентов</h3>

<?php $notify->accept(); ?>

<?php if (count($requests) == 0): ?>
<p>активные записи отсутствуют</p>
<?php else: ?>
<p>сортировать по:
<a href="<?= UrlManager::link('request/manager'); ?>" class="btn btn-outline-secondary btn-sm">имени клиента</a>
<a href="<?= UrlManager::link('request/manager'); ?>" class="btn btn-outline-secondary btn-sm">номеру телефона</a>
<a href="<?= UrlManager::link('request/manager'); ?>" class="btn btn-outline-secondary btn-sm">адресу эл. почты</a></p>
<div class="table-responsive">
  <table class="table custom-table">
    <thead>
      <tr>
        <th>{NAME}</th>
        <th>{PHONE}</th>
        <th>{EMAIL}</th>
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
  <?php
  echo Links::widget($pagination);
  ?>
</div>
<?php endif; ?>