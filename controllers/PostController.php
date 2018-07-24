<?php

namespace app\controllers;

use Yii;
use yii\base\Module;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\Cors;
use yii\filters\AjaxFilter;

use app\models\Post;
use app\services\PostService;
use app\repositories\PostRepository;

class PostController extends BaseController
{
    /**
     * PostService dependency
     * @var PostService
     */
    private $service;

    /**
     * PostRepository dependency
     * @var PostRepository
     */
    private $posts;

    /**
     * PostController constructor
     * @param                $id
     * @param Module         $module
     * @param PostService    $service
     * @param PostRepository $posts
     * @param array          $config
     */
    public function __construct(
        $id,
        Module $module,
        PostService $service,
        PostRepository $posts,
        array $config = []
    ) {
        $this->service = $service;
        $this->posts = $posts;
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
     * Creates new post
     * @return Post
     * @throws ServerErrorHttpException
     */
    public function actionCreate()
    {
        try {
            $model = new Post();
            $model = $this->loadModel($model, 'get', '');
            return $this->service->createPost($model);
        } catch (\Throwable $e) {
            Yii::error($e);
            throw new ServerErrorHttpException('Cannot create a post');
        }
    }

    /**
     * Gets all posts
     * @return Post[]
     * @throws ServerErrorHttpException
     */
    public function actionGetAll()
    {
        try {
            return ['posts' => $this->posts->getAllPosts()];
        } catch (\Throwable $e) {
            Yii::error($e);
            throw new ServerErrorHttpException('Cannot get all posts');
        }
    }

    /**
     * Gets single post by id
     * @param integer $id
     * @return Post
     * @throws ServerErrorHttpException
     */
    public function actionGetSingle($id)
    {
        try {
            $post = $this->posts->getPostById($id);
            $post->scenario = Post::SCENARIO_WITH_COMMENTARIES;
            return $post;
        } catch (\Throwable $e) {
            Yii::error($e);
            throw new ServerErrorHttpException('Cannot get single post');
        }
    }

    /**
     * Edits post by id
     * @param integer $id
     * @return Post
     * @throws ServerErrorHttpException
     */
    public function actionEdit($id)
    {
        try {
            $model = $this->posts->getPostById($id);
            $model = $this->loadModel($model, 'get', '');
            return $this->service->editPost($model);
        } catch (\Throwable $e) {
            Yii::error($e);
            throw new ServerErrorHttpException('Cannot edit a post');
        }
    }

    /**
     * Deletes post by id
     * @param integer $id
     * @return Post
     * @throws ServerErrorHttpException
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->posts->getPostById($id);
            return $this->service->deletePost($model);
        } catch (\Throwable $e) {
            Yii::error($e);
            throw new ServerErrorHttpException('Cannot delete a post');
        }
    }
}
