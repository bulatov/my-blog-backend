<?php

namespace app\repositories;

use yii\web\NotFoundHttpException;

use app\models\Commentary;

class CommentaryRepository {

    /**
     * Returns commentary model by id
     * @param integer $id
     * @return Commentary
     * @throws NotFoundHttpException if the commentary cannot be found
     */
    public function getCommentaryById($id):Commentary {
        if (($model = Commentary::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException();
    }
}
