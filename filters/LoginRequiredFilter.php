<?php

namespace app\filters;

use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class LoginRequiredFilter extends AccessControl {
    /**
     * Denies the access of the user.
     * 403 HTTP exception will be thrown.
     * @param User|false $user the current user or boolean `false` in case of detached User component
     * @throws ForbiddenHttpException
     */
    protected function denyAccess($user) {
        throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
    }
}
