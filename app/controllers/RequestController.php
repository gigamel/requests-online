<?php

namespace app\controllers;

use abstracts\Controller;
use app\models\Request;
use vendor\ASh\Session\PushNotify;
use vendor\ASh\Pager\Pagination;
use vendor\ASh\Url\UrlManager;
use vendor\ASh\Filter\DataFilter;

class RequestController extends Controller
{
    /**
     * @return void
     */
    public function actionManager(): void
    {
        $model = new Request();

        $filter = new DataFilter([
            'options' => [
                'name' => 'имени',
                'phone' => 'номеру телефона',
                'email' => 'адресу эл. почты'
            ]
        ]);
        
        $pagination = new Pagination([
            'total' => $model->getCount($filter->condition),
            'limit' => 20
        ]);
        
        $requests = $model->getList(
            $pagination->limit,
            $pagination->offset,
            'id DESC',
            $filter->condition
        );
        
        $notify = new PushNotify();
        
        $this->render('request/manager', [
            'requests' => $requests,
            'pagination' => $pagination,
            'notify' => $notify,
            'filter' => $filter
        ]);
    }

    /**
     * @param int $id
     */
    public function actionDelete(int $id = 0)
    {
        if ($id < 1) {
            $this->redirect(UrlManager::link('request/manager'));
        }
        
        $model = new Request();
        
        $request = $model->getBy('id', $id);
        if ($request === null) {
            $this->redirect(UrlManager::link('request/manager'));
        }
        
        if ($model->isSubmitted('confirm')) {
            $notify = new PushNotify();
            
            if ($request->delete()) {
                $notify->send('запись успешно удалена', 'success');
            } else {
                $notify->send('при удалении записи возникла ошибка', 'error');
            }
            
            $this->redirect(UrlManager::link('request/manager'));
        }
        
        $this->render('request/delete', [
            'request' => $request
        ]);
    }
}
