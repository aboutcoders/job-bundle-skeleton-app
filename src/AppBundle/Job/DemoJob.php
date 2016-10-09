<?php


namespace AppBundle\Job;


use Abc\Bundle\JobBundle\Annotation\ParamType;
use Abc\Bundle\JobBundle\Annotation\ReturnType;
use Psr\Log\LoggerInterface;

class DemoJob
{
    /**
     * @ParamType("to", type="string")
     * @ParamType("logger", type="@abc.logger")
     * @ReturnType("string")
     * @param string          $to
     * @param LoggerInterface $logger
     * @return string
     */
    public function sayHello($to, LoggerInterface $logger)
    {
        $message = 'Hello ' . $to;

        $logger->info($message);

        return $message;
    }
}