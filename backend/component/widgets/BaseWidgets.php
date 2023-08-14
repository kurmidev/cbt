<?php

namespace backend\component\widgets;

/**
 * Description of BaseWidgets
 *
 * @author chandrap
 */
abstract class BaseWidgets extends \yii\base\Widget {

    public function init() {
        parent::init();
        $this->generateData();
    }

    public function run() {
        return $this->template();
    }

    abstract function generateData();
    
    abstract function template();
}
