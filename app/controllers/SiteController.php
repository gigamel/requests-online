<?php
namespace app\controllers;

use abstracts\Controller;
use app\models\Request;
use vendor\ASh\Http\HttpRequest;
use vendor\ASh\Session\PushNotify;
use vendor\ASh\Pager\Pagination;

class SiteController extends Controller
{    
    public function actionIndex()
    {
        $notify = new PushNotify();
        
        $model = new Request();
        if ($model->isSubmitted()) {
            $httpRequest = new HttpRequest();
            
            $model->load($httpRequest->post('Client'));
            
            $response = $model->valid();
            if ($response === true) {
                $insertId = $model->insert();
                if ($insertId > 0) {
                    $notify->send('вы успешно записались', 'success');
                    
                    $this->redirect('/');
                }
                
                $this->attachErrors('возникла серверная ошибка');
            } else {
                $this->attachErrors($response);
            }
        }
        
        if ($this->hasErrors()) {
            $notify->send(implode('<br>', $this->errors), 'error');
        }
       
        $this->render('site/index', [
            'model' => $model,
            'notify' => $notify
        ]);
    }
}