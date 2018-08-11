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
use One\Support\Helpers\Json;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 显示服务信息命令
 *
 * ./onehub info <service>
 *
 * @package     One\Hub\Service\Commands
 * @author      Allen Luo <movoin@gmail.com>
 * @since       0.1
 */
class InfoCommand extends Command
{
    /**
     * 配置命令
     */
    protected function configure()
    {
        $this
            ->setName('info')
            ->setDescription('显示服务信息')
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
        $this->title('服务信息');
        // }}

        if (! $manager->exists($service)) {
            $this->symfony()->error(sprintf('服务名称 %s 未注册', $service));
            return 0;
        }

        $info = $manager->info($service);

        foreach ($info as $name => $value) {
            $this->symfony()->writeln(
                sprintf(
                    ' <info>%s</> %s',
                    str_pad(ucfirst($name), 12) . ':',
                    $this->getValue($value)
                )
            );
        }

        unset($manager, $info, $service);

        $this->newLine();

        return 0;
    }

    private function getValue($value)
    {
        if (is_array($value)) {
            return Json::encode($value);
        } elseif (empty($value)) {
            return '(empty)';
        }

        return $value;
    }
}
