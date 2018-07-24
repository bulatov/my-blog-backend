<?php

namespace app\controllers;

use Yii;
use yii\base\Module;
use yii\web\Response;

use app\models\LoginForm;
use app\components\FrontendRouter;
use app\services\AuthService;
use yii\web\UnauthorizedHttpException;

class AuthController extends BaseController
{
    /**
     * @var FrontendRouter component dependency
     */
    private $frontendRouter;

    /**
     * @var AuthService service dependency
     */
    private $service;

    /**
     * AuthController constructor.
     * @param string $id
     * @param Module $module
     * @param FrontendRouter $frontendRouter
     * @param AuthService $authService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        FrontendRouter $frontendRouter,
        AuthService $authService,
        array $config = []
    ) {
        $this->frontendRouter = $frontendRouter;
        $this->service = $authService;
        parent::__construct($id, $module, $config);
    }

    /**
     * Login action.
     *
     * @return Response
     * @throws UnauthorizedHttpException
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect($this->frontendRouter->getRoot());
        }

        try {
            $form = new LoginForm();
            $this->loadAndValidateModel($form, 'post');
            $this->validatePassword($form);
            $this->service->login($form);
            return $this->redirect($this->frontendRouter->getRoot());
        } catch (\Throwable $e) {
            Yii::error($e);
            return $this->redirect($this->frontendRouter->getUrlByPage('login'));
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        try {
            $this->service->logout();
            return $this->redirect($this->frontendRouter->getUrlByPage('login'));
        } catch (\Throwable $e) {
            Yii::error($e);
            return $this->redirect($this->frontendRouter->getRoot());
        }
    }

    /**
     * CSRF token action.
     * @return array
     */
    public function actionCsrfToken()
    {
        return ['csrfToken' => Yii::$app->request->getCsrfToken()];
    }

    /**
     * @param $form
     * @throws UnauthorizedHttpException
     */
    private function validatePassword($form)
    {
        $user = \app\models\User::findByUsername($form->username);
        if (!$user || !$user->validatePassword($form->password)) {
            throw new UnauthorizedHttpException();
        }
    }
}