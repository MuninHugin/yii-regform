<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\PostForm;
use yii\helpers\Html;
use app\models\UsersDB;

class SiteController extends Controller
{

    public function actionIndex()
    {
        $post_form = new PostForm();
        $request = Yii::$app->request;
        $get_secret_key = $request->get('secret_key');
        $user_info = '';

        if ($post_form->load(Yii::$app->request->post()) && $post_form->validate()) {
            $name = Html::encode($post_form->name);
            $email = Html::encode($post_form->email);
            $password = md5($post_form->password);
            $secret_key = md5($post_form->email);
            $secret_url = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"].'/?secret_key='.$secret_key;

            if (\Yii::$app->db->getTableSchema('{{%users_db}}', true) !== null) {
                $users_data = new UsersDB();
                $users_data->name = $name;
                $users_data->email = $email;
                $users_data->password = $password;
                $users_data->secret_key = $secret_key;

                $users_data->save();
            }
            $post_form->sendEmail('Активируйте ваш email по ссылке <a href="'.$secret_url.'">'.$secret_url.'</a>');
        }
        if(isset($get_secret_key)) {
            $user_data = UsersDB::find()->where(['secret_key' => $get_secret_key])->one();

            if($get_secret_key === $user_data->secret_key) {
                $user_info = 'Email активирован';
                $user_data->status = 1;
                $user_data->save();
            }
        }

        return $this->render('index', [
            'post_form' => $post_form,
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'user_info' => $user_info
        ]);
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}
