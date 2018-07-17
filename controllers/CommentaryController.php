<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\base\Module;
use yii\filters\Cors;

use app\models\Commentary;

/**
 * Commentary controller for the `commentaries` module
 */
class CommentaryController extends Controller
{
    /**
     * Exception for all kinds of error while performing an action
     * @var \yii\web\HttpException
     */
    private $invalidRequestException;

    /**
     * CommentaryController constructor.
     * @param $id
     * @param Module $module
     * @param array $config
     */
    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->invalidRequestException = new \yii\web\HttpException(400, 'Invalid request');
    }

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => Cors::className(),
                'cors' => [
                    'Origin'                           => ['http://localhost:3000'],
                    'Access-Control-Allow-Origin'      => ['http://localhost:3000'],
                    'Access-Control-Request-Method'    => ['POST', 'GET'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,
                    'Access-Control-Request-Headers'     => ['X-Requested-With'],
                ],
            ],
            'app\filters\AjaxOnlyAccess',
        ];
    }

    /**
     * Returns JSON containing all commentaries
     * @return string
     */
    public function actionIndex()
    {
        return $this->asJson(Commentary::find()->all());
    }

    /**
     * Creates new commentary
     * get params: post_id, post_id, [parent_id], content
     * @return \yii\web\Response
     * @throws \yii\web\HttpException
     */
    public function actionCreate() {
        $model = new Commentary();

        if ($model->load(Yii::$app->request->get(), '') && $model->save()) {
            return $this->asJson($model);
        } else {
            throw $this->invalidRequestException;
        }
    }

    /**
     * Deletes a commentary by id
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     */
    public function actionDelete($id) {
        $model = Commentary::find($id)->one();

        try {
            $model->delete();
            return $this->asJson($model);
        } catch (\Exception $e) {
            throw $this->invalidRequestException;
        }
    }
}
