<?php

namespace app\services;

use Yii;
use app\models\Commentary;

class CommentaryService {
    private $invalidRequestException;

    public function __construct() {
        $this->invalidRequestException = new \yii\web\HttpException(400, 'Invalid request');
    }

    public function createCommentary() {
        $model = new Commentary();

        if ($model->load(Yii::$app->request->get(), '') && $model->save()) {
            return $model;
        } else {
            throw $this->invalidRequestException;
        }
    }
}
