<?php

namespace app\repositories;

use yii\web\NotFoundHttpException;

use app\models\Post;

class PostRepository {

    /**
     * Returns post model by id
     * @param integer $id
     * @return Post
     * @throws NotFoundHttpException if the post cannot be found
     */
    public function getPostById($id):Post {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException();
    }

    /**
     * Returns all posts
     * @return Post[]
     */
    public function getAllPosts():array {
        return Post::find()->with('commentaries')->all();
    }

    /**
     * Returns boolean indicating that Post with specified conditions exists
     * @param array $conditions
     * @return boolean
     */
    public function isPostExists($conditions) {
        return Post::find()
            ->where($conditions)
            ->exists();
    }
}
