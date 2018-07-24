<?php

namespace app\bootstrap;

use Yii;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::$container->setSingleton('app\components\FrontendRouter', [
            'root' => 'http://localhost:3000',
            'pages' => ['login']
        ]);
    }
}