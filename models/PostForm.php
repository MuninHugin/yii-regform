<?php

namespace app\models;

use Yii;
use yii\base\Model;


class PostForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $verifyCode;

    public $subject = 'Активация email';

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required', 'message' => 'Пожалуйста, заполните это поле'],
            ['email', 'email', 'message' => 'Невалидная запись e-mail'],
            ['email','unique','targetAttribute' => 'email','targetClass' => 'app\models\UsersDB','message' =>  'Такой email уже зарегистрирован'],
            ['password', 'string', 'min' => 6, 'tooShort' => "Длина пароля не менее 6 символов"],
            ['verifyCode', 'captcha', 'message' => 'Неправильная капча']
        ];
    }

    public function sendEmail($body)
    {
       $result = Yii::$app->mailer->compose()
                ->setTo($this->email)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Admin'])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($body)
                ->send();
        return $result;
    }
}
