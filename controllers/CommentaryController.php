<?php

namespace app\controllers;

use Yii;
use yii\base\Module;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\Cors;
use yii\filters\AjaxFilter;

use app\models\Commentary;
use app\services\CommentaryService;
use app\repositories\CommentaryRepository;

class CommentaryController extends BaseController
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
     * @param                      $id
     * @param Module               $module
     * @param CommentaryService    $service
     * @param CommentaryRepository $commentaries
     * @param array                $config
     */
    public function __construct(
        $id,
        Module $module,
        CommentaryService $service,
        CommentaryRepository $commentaries,
        array $config = []
    ) {
        $this->service = $service;
        $this->commentaries = $commentaries;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            [
                'class' => Cors::className(),
                'cors' => require __DIR__ . '/../config/cors.config.php'
            ],
            AjaxFilter::className()
        ];
    }

    /**
     * Creates new commentary
     * @return Commentary
     * @throws ServerErrorHttpException
     */
    public function actionCreate()
    {
        try {
            $model
                = new Commentary(['scenario' => Commentary::SCENARIO_CREATE]);
            $model = $this->loadModel($model, 'get', '');
            return $this->service->createCommentary($model);
        } catch (\Throwable $e) {
            Yii::error($e);
            throw new ServerErrorHttpException('Cannot create a commentary');
        }
    }

    /**
     * Edits commentary by id
     * @param integer $id
     * @return Commentary
     * @throws ServerErrorHttpException
     */
    public function actionEdit($id)
    {
        try {
            $model = $this->commentaries->getCommentaryById($id);
            $model->scenario = Commentary::SCENARIO_EDIT;
            $model = $this->loadModel($model, 'get', '');
            return $this->service->editCommentary($model);
        } catch (\Throwable $e) {
            Yii::error($e);
            throw new ServerErrorHttpException('Cannot edit a commentary');
        }
    }

    /**
     * Deletes commentary by id
     * @param integer $id
     * @return Commentary
     * @throws ServerErrorHttpException
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->commentaries->getCommentaryById($id);
            return $this->service->deleteCommentary($model);
        } catch (\Throwable $e) {
            Yii::error($e);
            throw new ServerErrorHttpException('Cannot delete a commentary');
        }
    }
}
