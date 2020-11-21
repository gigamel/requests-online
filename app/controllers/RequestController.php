<?php
namespace app\controllers;

use abstracts\Controller;
use app\models\Request;
use vendor\ASh\Http\HttpRequest;
use vendor\ASh\Session\PushNotify;
use vendor\ASh\Pager\Pagination;
use vendor\ASh\Url\UrlManager;

class RequestController extends Controller
{
    public function actionManager()
    {
        $model = new Request();

        $pagination = new Pagination([
            'total' => $model->getCount(),
            'limit' => 20
        ]);
        
        $requests = $model->getList($pagination->limit, $pagination->offset,
            'id DESC');
        
        $notify = new PushNotify();
        
        $this->render('request/manager', [
            'requests' => $requests,
            'pagination' => $pagination,
            'notify' => $notify
        ]);
    }
    
    /**
     * @param int $id
     */
    public function actionDelete($id = null)
    {
        $id = (int) $id;
        if ($id == 0) {
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