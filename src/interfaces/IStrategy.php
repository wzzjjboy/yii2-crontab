<?php


namespace yii2\crontab\interfaces;


interface IStrategy {

    public function run(): bool ;
}