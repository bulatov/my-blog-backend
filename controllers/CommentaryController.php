<?php

namespace app\controllers;

use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\web\Response;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\Cors;
use yii\filters\AjaxFilter;

use app\models\Commentary;
use app\services\CommentaryService;
use app\repositories\CommentaryRepository;

class CommentaryController extends Controller
{
    /**
     * CommentaryService dependency
     * @var CommentaryService
     */
    private $service;

    /**
     * CommentaryRepository dependency
     * @var CommentaryRepository
     */
    private $commentaries;

    /**
     * CommentaryController constructor
     * @param $id
     * @param Module $module
     * @param CommentaryService $service
     * @param CommentaryRepository $commentaries
     * @param array $config
     */
    public function __construct($id, Module $module, CommentaryService $service, CommentaryRepository $commentaries, array $config = [])
    {
        $this->service = $service;
        $this->commentaries = $commentaries;
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
     * @return Response
     * @throws ServerErrorHttpException
     */
    public function actionCreate() {
        try {
            $model = $this->loadModel(new Commentary());
            return $this->service->createCommentary($model);
        } catch(\Throwable $e) {
            Yii::error($e);
            throw new ServerErrorHttpException('Cannot create a commentary');
        }
    }

    /**
     * Edits commentary by id
     * @param integer $id
     * @return Response
     * @throws ServerErrorHttpException
     */
    public function actionEdit($id) {
        try {
            $model = $this->commentaries->findCommentaryById($id);
            $model = $this->loadModel($model);
            return $this->service->editCommentary($model);
        } catch(\Throwable $e) {
            Yii:error($e);
            throw new ServerErrorHttpException('Cannot edit a commentary');
        }
    }

    /**
     * Deletes commentary by id
     * @param integer $id
     * @return Response
     * @throws ServerErrorHttpException
     */
    public function actionDelete($id) {
        try {
            $model = $this->commentaries->getCommentaryById($id);
            return $this->service->deleteCommentary($model);
        } catch(\Throwable $e) {
            Yii::error($e);
            throw new ServerErrorHttpException('Cannot delete a commentary');
        }
    }

    /**
     * Loads data from request into model
     * @param Commentary $model
     * @return Commentary model filled with data
     * @throws BadRequestHttpException if request data cannot be loaded into model
     */
    private function loadModel(Commentary $model):Commentary {
        if ($model->load(Yii::$app->request->get(), '')) {
            return $model;
        }

        throw new BadRequestHttpException('Unable to verify your data submission');
    }
}
