<?php

namespace common\models;

use yii\helpers\Url;
use Yii;



class UpdatePassword extends User
{

    public $id;
    public $email;
    public $password;



    public function rules()
    {
        return [


            [['password'], 'string' , 'message' => \Yii::t('app','password')],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => \Yii::t('app','asd')],

        ];
    }

    public function updatePassword($id,$email,$password)
    {
        $user = User::findOne($id);
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->email = $email;
        if ($user->update()){
            return true;
        }else{
            file_put_contents(__DIR__.'/err.txt' ,serialize($user->getErrors()));
            return $user->getErrors();
        }

    }
}