<?php

namespace app\services;

use Yii;
use yii\web\ServerErrorHttpException;

use app\models\Commentary;
use app\repositories\CommentaryRepository;

class CommentaryService {

    /**
     * Creates commentary
     * @param Commentary $model
     * @return Commentary created commentary
     * @throws ServerErrorHttpException if the model cannot be saved
     */
    public function createCommentary(Commentary $model):Commentary {
        if ($model->save()) {
            return $model;
        }

        throw new ServerErrorHttpException();
    }

    /**
     * Edits commentary
     * @param Commentary $model
     * @return Commentary edited Commentary
     * @throws ServerErrorHttpException if the model cannot be saved
     */
    public function editCommentary(Commentary $model):Commentary {
        if ($model->save()) {
            return $model;
        }

        throw new ServerErrorHttpException();
    }

    /**
     * Deletes commentary
     * @param Commentary $model
     * @return Commentary deleted commentary
     */
    public function deleteCommentary(Commentary $model):Commentary {
        $model->delete();
        return $model;
    }
}
