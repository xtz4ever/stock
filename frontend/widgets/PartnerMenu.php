<?php
namespace frontend\widgets;

class PartnerMenu extends \yii\base\Widget
{
    public function init(){}

    public function run() {
        return $this->render('parnter-menu/view');
    }
}