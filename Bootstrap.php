<?php

namespace openecontmd\bank_api;

use yii\base\BootstrapInterface;
use Yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        /*
         * Регистрация модуля в приложении
         * (вместо указания в файле config/web.php
         */
        $app->setModule('bank', 'openecontmd\bank_api\modules\bank\Module');
    }
}
