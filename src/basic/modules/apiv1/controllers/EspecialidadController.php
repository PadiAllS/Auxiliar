<?php

namespace app\modules\apiv1\controllers;

//use yii\web\Controller;

use app\modules\apiv1\models\Especialidad;
use backend\behaviours\Apiauth;
use backend\behaviours\Verbcheck;
use yii\filters\AccessControl;
use yii\rest\ActiveController;

/**
 * Default controller for the `apiv1` module
 */
class EspecialidadController extends DefaultController
{
    public $modelClass = Especialidad::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();



       return $behaviors + [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create','delete','update'],
                'rules' => [
                    [
                        'actions' => [
                            'create',
                            'delete',
                            'update',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

}
