<?php
/**
 * Author: CodeSinging <codesinging@gmail.com>
 * Time: 2019/12/7 09:49
 */

namespace CodeSinging\ThinkCommand;

class Command extends \think\console\Command
{
    /**
     * Output a blank line.
     */
    protected function blank()
    {
        $this->output->newLine();
    }

    /**
     * Output a title.
     *
     * @param $title
     */
    protected function title($title)
    {
        $this->output->comment('- ' . $title);
    }

    /**
     * Output a message with info style.
     *
     * @param string $message
     */
    protected function info($message)
    {
        $this->output->info($message);
    }

    /**
     * Output a message with warning style.
     *
     * @param string $message
     */
    protected function warning($message)
    {
        $this->output->warning($message);
    }

    /**
     * Output a message with error style.
     *
     * @param string $message
     */
    protected function error($message)
    {
        $this->output->error($message);
    }
}