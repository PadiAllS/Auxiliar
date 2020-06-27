<?php

namespace app\modules\apiv1;

/**
 * apiv1 module definition class
 */
class Apiv1Modules extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\apiv1\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
        \Yii::$app->user->enableAutoLogin = false;

        // custom initialization code goes here
    }
}
