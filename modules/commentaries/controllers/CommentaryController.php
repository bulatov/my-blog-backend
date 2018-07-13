<?php

namespace app\modules\commentaries\controllers;

use Yii;
use yii\web\Controller;

use app\modules\commentaries\models\Commentary;

/**
 * Commentary controller for the `commentaries` module
 */
class CommentaryController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Creates new commentary
     * get params: content, user_id, created_at, position
     *
     * @return \yii\web\Response
     * @throws \yii\web\HttpException
     */
    public function actionCreate() {
        $model = new Commentary();

        if ($model->load(Yii::$app->request->get(), '') && $model->save()) {
            return $this->asJson($model);
        } else {
            throw new \yii\web\HttpException(400, 'Invalid request params');
        }
    }
}
