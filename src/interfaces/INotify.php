<?php


namespace yii2\crontab\interfaces;


use yii\base\BaseObject;

abstract class INotify extends BaseObject implements IHandler {

    public function handler(...$args) {
        $this->notify();
    }

    abstract function notify(): bool;
}