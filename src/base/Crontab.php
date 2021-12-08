<?php


namespace yii2\crontab\base;


use yii\base\NotSupportedException;
use yii2\crontab\interfaces\IHandler;
use yii2\crontab\interfaces\IStrategy;
use yii2\crontab\interfaces\ITarget;

class Crontab {

    use InstanceTrait;

    /**
     * @var ITarget
     */
    private $target;
    /**
     * @var IHandler
     */
    private $handler;
    /**
     * @var IStrategy
     */
    private $strategy;


    public function withTargetData(ITarget $target) {
        $this->target = $target;
        return $this;
    }

    public function withHandler($handler) {
        $this->handler = $handler;
        return $this;
    }

    public function withStrategy(IStrategy $strategy) {
        $this->strategy = $strategy;
        return $this;
    }

    public function run() {
        try {
            $data = $this->target->getTargetData();
            if ($this->handler instanceof IHandler) {
                return $this->handler->handler($data);
            } elseif (is_callable($this->handler)) {
                $rsp = call_user_func_array($this->handler, [$data]);
                if ($rsp instanceof IStrategy) {
                    return $rsp->run();
                }
                return $rsp;
            } else {
                throw new NotSupportedException("无支持的handler类型");
            }
        } catch (\Exception $exception) {
            $msg = "";
            if (!empty($data)){
                $msg = json_encode($data, JSON_UNESCAPED_UNICODE);
            }
            echo sprintf("crontab has exception: %s, data:%s", $exception->getMessage(), $msg);
        }
    }
}