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
use One\Hub\Service\Factory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 启用服务命令
 *
 * ./onehub enable <service>
 *
 * @package     One\Hub\Service\Commands
 * @author      Allen Luo <movoin@gmail.com>
 * @since       0.1
 */
class EnableCommand extends Command
{
    /**
     * 配置命令
     */
    protected function configure()
    {
        $this
            ->setName('enable')
            ->setDescription('启用服务')
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
        $manager = Factory::newManager();
        $service = $input->getArgument('service');

        // {{
        $this->title('启用服务');
        // }}

        if (! $manager->exists($service)) {
            $this->error(sprintf('服务名称 %s 未注册', $service));
            return 0;
        }

        $this->result(sprintf('启用 <label>%s</> 服务', $service), $manager->setStatus($service, 'on'));
        $this->newLine();

        return 0;
    }
}
