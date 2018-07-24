<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

class BaseController extends Controller
{
    /**
     * Loads data from request into model
     * @param Model $model
     * @param string $method request object property ('get', 'post', ...)
     * @param string|null $formName
     * @return Model
     * @throws BadRequestHttpException
     */
    public function loadModel($model, $method, $formName = null)
    {
        if ($model->load(Yii::$app->request->{$method}(), $formName)) {
            return $model;
        }

        throw new BadRequestHttpException('Unable to verify your data submission');
    }

    /**
     * Loads data from request into model, then validates it
     * @param Model $model
     * @param string $method request object property ('get', 'post', ...)
     * @param string|null $formName
     * @return Model
     * @throws BadRequestHttpException
     */
    public function loadAndValidateModel($model, $method, $formName = null)
    {
        $this->loadModel($model, $method, $formName);

        if (!$model->validate()) {
            throw new BadRequestHttpException('Unable to load and validate your data submission');
        }

        return $model;
    }
}