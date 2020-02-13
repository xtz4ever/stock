<?php
namespace frontend\widgets;

class ProviderMenu extends \yii\base\Widget
{
    public function init(){}

    public function run() {
        return $this->render('provider-menu/view');
    }
}
