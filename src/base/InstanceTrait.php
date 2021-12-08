<?php

namespace yii2\crontab\base;

use Yii;

trait InstanceTrait
{
    private static $instance =  null;

    /**
     * @param array $params
     * @param bool $singleton
     * @throws \yii\base\InvalidConfigException
     * @return static
     */
    public static function instance($params = [], $singleton = false){

        if(!static::$instance || !$singleton){
            $cnf = [
                'class' => static::class,
            ];
            unset($params['class']);
            $cnf = array_merge($cnf, $params);
            static::$instance = Yii::createObject($cnf);
        }

        return static::$instance;
    }
}