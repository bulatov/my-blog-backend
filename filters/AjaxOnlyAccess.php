<?php

namespace app\filters;

use Yii;
use yii\base\ActionFilter;

class AjaxOnlyAccess extends ActionFilter {

    /**
     * Throws exception if request is not ajax
     *
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\HttpException
     */
    public function beforeAction($action)
    {
        if (!Yii::$app->request->isAjax) {
            throw new \yii\web\HttpException(405, 'Only ajax requests are allowed');
        }

        return parent::beforeAction($action);
    }
}
