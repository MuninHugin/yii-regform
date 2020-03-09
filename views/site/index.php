<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Pjax;

$this->title = 'Страница регистрации';
?>
<?php Pjax::begin(); ?>

<div class="wrap">
    <div class="container main">
        <div class="form_wrap">
            <?php if($user_info){?>
                <h2 class="activation_alert"><?=$user_info?></h2>
            <?php } else {?>
            <?php $form = ActiveForm::begin(['options'=> ['data-pjax' => true, 'id' => 'post-form']]); ?>
            <div class="row">

                <div class="col-xs-12">
                    <h3 class="form_header">Форма регистрации</h3>
                    <?= $form->field($post_form, 'name',['template' => '{label}{input}{error}'])
                        ->textInput(['class' => 'field'])
                        ->label('Имя') ?>
                    <?= $form->field($post_form, 'email',['template' => '{label}{input}{error}'])
                        ->textInput(['class' => 'field'])
                        ->label('E-Mail') ?>
                    <?= $form->field($post_form, 'password')->passwordInput(['class' => 'field'])->label('Пароль') ?>
                    <?= $form->field($post_form, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                        'imageOptions' => [
                            'id' => 'my-captcha-image'
                        ],
                        'options' => [
                            'class' => 'field'
                        ]
                        ])->label('Капча') ?>
                    <p><button class="send send-js">Регистрация</button></p>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <?}?>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
