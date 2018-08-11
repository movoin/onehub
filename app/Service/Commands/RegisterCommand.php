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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 服务注册命令
 *
 * ./onehub register [-s|--schema [SCHEMA]] [--] <service> [<description> [<engine> [<backend>]]]
 *
 * @package     One\Hub\Service\Commands
 * @author      Allen Luo <movoin@gmail.com>
 * @since       0.1
 */
class RegisterCommand extends Command
{
    /**
     * 配置命令
     */
    protected function configure()
    {
        $this
            ->setName('register')
            ->setDescription('注册服务')
            ->addArgument('service', InputArgument::REQUIRED, '服务名称')
            ->addArgument('description', InputArgument::OPTIONAL, '服务描述')
            ->addArgument('engine', InputArgument::OPTIONAL, '服务引擎')
            ->addArgument('backend', InputArgument::OPTIONAL, '存储后端')
            ->addOption('schema', 's', InputOption::VALUE_OPTIONAL, '数据结构')
            ->setHelp(<<<'EOF'
支持服务引擎:

  <info>+ log</>
  <info>+ trace</>
  <info>+ stats</>

支持存储后端:

  <info>+ mysql</>
  <info>+ redis</>
  <info>+ mongodb</>
  <info>+ elasticsearch</>

示例: <info>php %command.full_name% <comment>service</> <comment>log</> <comment>redis</></>

EOF
            )
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
        $service = [
            'name' => $input->getArgument('service')
        ];

        // {{
        $this->title('注册服务');
        // }}

        if (($service['description'] = $input->getArgument('description')) === null) {
            $service['description'] = $this->symfony()->ask('填写服务描述', '');
        }

        if (($service['engine'] = $input->getArgument('engine')) === null) {
            $service['engine'] = $this->symfony()->choice(
                '选择服务引擎',
                ['log', 'trace', 'stats'],
                'log'
            );
        }

        if (($service['backend'] = $input->getArgument('backend')) === null) {
            $service['backend'] = $this->symfony()->choice(
                '选择存储后端',
                ['redis', 'mysql', 'mongodb', 'elasticsearch'],
                'redis'
            );
        }

        $manager = Factory::newManager();

        if ($manager->exists($service['name'])) {
            $this->symfony()->error(sprintf('服务名称 %s 已注册', $service['name']));
            return 0;
        }

        $msg = '注册服务 <label>%s</> ';

        if ($manager->register($service)) {
            $this->ok(sprintf($msg, $service['name']));
        } else {
            $this->fail(sprintf($msg, $service['name']));
        }

        unset($manager, $msg, $service);

        $this->newLine();

        return 0;
    }
}
