<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\base\Module;
use yii\filters\Cors;
use yii\filters\AjaxFilter;

use app\models\Commentary;
use app\services\CommentaryService;

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
    private $service;

    /**
     * CommentaryController constructor.
     * @param $id
     * @param Module $module
     * @param array $config
     */
    public function __construct($id, Module $module, CommentaryService $service, array $config = [])
    {
        $this->invalidRequestException = new \yii\web\HttpException(400, 'Invalid request');
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            [
                'class' => '\yii\filters\Cors',
                'cors' => [
                    'Origin'                           => ['http://localhost:3000'],
                    'Access-Control-Request-Method'    => ['POST', 'GET'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,
                    'Access-Control-Request-Headers'     => ['X-Requested-With'],
                ],
            ],
            '\yii\filters\AjaxFilter'
        ];
    }

    /**
     * Creates new commentary
     * get params: post_id, post_id, [parent_id], content
     * @return \yii\web\Response
     * @throws \yii\web\HttpException
     */
    public function actionCreate() {
        $model = new Commentary();

        try {
            return $this->service->createCommentary();
        } catch(\Exception $e) {
            throw $e;
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
            return $model;
        } catch (\Exception $e) {
            throw $this->invalidRequestException;
        }
    }
}
