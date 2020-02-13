<?php
namespace frontend\widgets;
use frontend\models\Lang;

class WLang extends \yii\bootstrap\Widget
{
    public function init(){}

    public function run() {
        return $this->render('lang/view', [
            'current' => Lang::getCurrent(),
            'current_lang_name' => Lang::getCurrent()->name,
            'langs' => Lang::find()->where('id != :current_id', [':current_id' => Lang::getCurrent()->id])->all(),
        ]);
    }
}