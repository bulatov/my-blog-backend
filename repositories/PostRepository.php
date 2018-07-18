<?php

namespace app\repositories;

use app\models\Post;

class PostRepository {

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
