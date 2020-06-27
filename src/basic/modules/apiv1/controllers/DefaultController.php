<?php

namespace app\modules\apiv1\controllers;

use yii\web\Controller;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\Usuario;
use Yii;

/**
 * Default controller for the `apiv1` module
 */
class DefaultController extends ActiveController
{

public function behaviors()
{
    $behaviors = parent::behaviors();

    // remove authentication filter
    $auth = $behaviors['authenticator'];
    unset($behaviors['authenticator']);

    // add CORS filter
    $behaviors['corsFilter'] = [
        'class' => \yii\filters\Cors::className(),
    ];

    // re-add authentication filter
    $behaviors['authenticator'] = $auth;

//    $behaviors['authenticator'] = [
//        'class' => CompositeAuth::className(),
//        'authMethods' => [
//              [
//                 'class'=> HttpBasicAuth::className(),
//                 'auth'=> function($username, $password){
//                     $user= Usuario::find()->where(['username'=>$username])->one();
//                     if ($user!=null && $user->validatePassword($password)){
//                         return $user;
//                     }
//                     return null;
//                 }
//             ],
//            HttpBearerAuth::className(),
//            QueryParamAuth::className(),
//        ],
//    ];

    // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
//    $behaviors['authenticator']['except'] = ['options'];

    return $behaviors;
}


}
