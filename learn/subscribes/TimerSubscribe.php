<?php


namespace learn\subscribes;


class TimerSubscribe
{
    /**
     * 每隔1秒执行的任务
     */
    public function onTask_1()
    {
        var_dump(1);
    }

    /**
     * 每隔5秒执行的任务
     */
    public function onTask_5()
    {
        var_dump(5);
    }

    /**
     * 每隔10秒执行的任务
     */
    public function onTask_10()
    {
        var_dump(10);
    }

    /**
     * 每隔30秒执行的任务
     */
    public function onTask_30()
    {
        var_dump(30);
    }

    /**
     * 每隔60秒执行的任务
     */
    public function onTask_60()
    {
        var_dump(60);
    }
}