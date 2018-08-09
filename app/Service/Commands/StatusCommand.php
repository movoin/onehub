<?php
/**
 * This file is part of the One package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     One\Hub\Service\Commands
 * @author      Allen Luo <movoin@gmail.com>
 * @since       0.1
 */

namespace One\Hub\Service\Commands;

use One\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 显示服务状态命令
 *
 * ./onehub status <service>
 *
 * @package     One\Hub\Service\Commands
 * @author      Allen Luo <movoin@gmail.com>
 * @since       0.1
 */
class StatusCommand extends Command
{
    /**
     * 配置命令
     */
    protected function configure()
    {
        $this
            ->setName('status')
            ->setDescription('显示服务状态')
            ->addArgument('service', InputArgument::REQUIRED, '服务名称')
        ;
    }

    /**
     * 执行命令
     *
     * @param  \Symfony\Component\Console\Input\InputInterface      $input
     * @param  \Symfony\Component\Console\Output\OutputInterface    $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
