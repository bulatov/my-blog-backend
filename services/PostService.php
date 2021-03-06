<?php

namespace app\services;

use yii\web\ServerErrorHttpException;
use yii\db\StaleObjectException;

use app\models\Post;

class PostService
{

    /**
     * Creates post
     * @param Post $model
     * @return Post created post
     * @throws ServerErrorHttpException if the model cannot be saved
     */
    public function createPost(Post $model): Post
    {
        if ($model->save()) {
            return $model;
        }

        throw new ServerErrorHttpException();
    }

    /**
     * Edits post
     * @param Post $model
     * @return Post edited Post
     * @throws ServerErrorHttpException if the model cannot be saved
     */
    public function editPost(Post $model): Post
    {
        if ($model->save()) {
            return $model;
        }

        throw new ServerErrorHttpException();
    }

    /**
     * Deletes post
     * @param Post $model
     * @return Post deleted post
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function deletePost(Post $model): Post
    {
        $model->delete();
        return $model;
    }
}
