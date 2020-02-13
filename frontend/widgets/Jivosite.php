<?php
namespace frontend\widgets;

class Jivosite extends \yii\base\Widget
{
    public function init(){}

    public function run() {
        return $this->render('jivosite/view');
    }
}