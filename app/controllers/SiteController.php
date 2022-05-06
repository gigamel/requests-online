<?php

namespace app\controllers;

use abstracts\Controller;
use app\models\Request;
use vendor\ASh\Http\HttpRequest;
use vendor\ASh\Session\PushNotify;

class SiteController extends Controller
{
    /**
     * @return void
     */
    public function actionIndex(): void
    {
        $notify = new PushNotify();

        $model = new Request();
        if ($model->isSubmitted()) {
            $httpRequest = new HttpRequest();

            $model->load($httpRequest->post('Client'));
            $model->valid();

            if ($model->hasErrors()) {
                $this->attachErrors($model->getErrors());
            } elseif ($model->insert() > 0) {
                $notify->send('вы успешно записались', 'success');
                $this->redirect('/');
            } else {
                $this->attachErrors('возникла серверная ошибка');
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
