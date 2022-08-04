<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


$this->params['breadcrumbs'][] = $this->title;

?>





<?php $form = ActiveForm::begin(['id' => 'login-form']);

if (Yii::$app->session->hasFlash('success')) {
    print '<div class="alert alert-success">' . Yii::$app->session->getFlash('success') . '</div>';
}

if (Yii::$app->session->hasFlash('error')) {
    print '<div class="alert alert-danger">' . Yii::$app->session->getFlash('error') . '</div>';
}

$form->errorSummary($model);

?>

<?= $form->field($model, 'username', [
    'inputTemplate' => '<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span>{input}</div>',
])
    ->textInput([
        'autofocus' => true,
        'placeholder' => 'Username',
        'autocomplete' => 'off'
    ])
    ->label(false)
?>



<?= $form->field($model, 'password', [
    'inputTemplate' => '<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span>{input}</div>'
])->passwordInput([
    'Placeholder' => 'Password',
    'autocomplete' => 'off'
])
    ->label(false)
?>



<?php $form->field($model, 'rememberMe')->checkbox() ?>


<!--<div class="form-group">

                     <?/*= '<p class="text-white">Click  here to '. Html::a('Reset Password', ['/site/request-password-reset'],['class' => '']). '.</p>' */ ?>
                </div>-->

<div class="form-group">
    <?= Html::submitButton('Login', ['class' => 'btn bg-warning', 'name' => 'login-button']) ?>

    <!-- <?/*= '<p class="text-white">Click  here to '. Html::a('resend', ['/site/resend-verification-email'],['class' => '']). ' verification token .</p>' */ ?>

                    <?/*= '<p class="text-white">Don\'t have an account?  '. Html::a('signup', ['/site/signup'],['class' => '']). ' here .</p>' */ ?>
               -->
</div>

<?php ActiveForm::end(); ?>



<?php
$directory = Yii::getAlias('@app') . '/web/background';
@chdir($directory);
$images = glob("*.{jpg,JPG,jpeg,JPEG,png,PNG}", GLOB_BRACE);


$random_img = $images[array_rand($images)];



$style = <<<CSS
    .login-page { 
         /* background: url("../../background/$random_img") no-repeat center center fixed; */
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
         

    }


    .top-logo {
        display: flex;
        margin-left: 10px;
       
    }
     .top-logo img { 
                width: 120px;
                height: auto;
                position: absolute;
                left: 15px;
                top:15px;
                
          
            }
     .login-logo a  {
        color: #ffffff!important;
        font-family: sans-serif, Verdana;
        font-size: larger;
        font-weight: 400;
        text-shadow: 2px 2px 8px #8B2323;

     }

    input.form-control {
        border-left: 0!important;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border: 1px solid #f6c844;
    }
    
    span.input-group-text {
        border-right: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border: 1px solid #f6c844;
    }
    
  
    
    
CSS;

$this->registerCss($style);
