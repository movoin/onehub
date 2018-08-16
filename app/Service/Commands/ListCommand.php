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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 显示服务列表命令
 *
 * ./onehub ls
 *
 * @package     One\Hub\Service\Commands
 * @author      Allen Luo <movoin@gmail.com>
 * @since       0.1
 */
class ListCommand extends Command
{
    /**
     * 配置命令
     */
    protected function configure()
    {
        $this
            ->setName('ls')
            ->setDescription('显示服务列表')
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
        // {{
        $this->title('服务列表');
        // }}

        $manager = Factory::newManager();

        if ($manager->count() === 0) {
            $this->error('未注册任何服务');
            return 0;
        }

        $services = array_filter($manager->all(), function ($val) {
            return isset($val['name']);
        });

        $format = [
            ' <info>-></> <name> - <description>  |  ',
            'Engine: <engine>  Backend: <backend>  Status: [<status>]  Created: <created>'
        ];

        foreach ($services as $service) {
            unset($service['schema']);

            $this->formatLine(
                implode('', $format),
                $service,
                [
                    'name' => 'highlight',
                    'engine' => 'title',
                    'backend' => 'title',
                    'status' => $service['status'] === 'on' ? 'success' : 'failure',
                    'created' => 'title',
                ]
            );
        }

        return 0;
    }
}
