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
use One\Support\Exceptions\JsonException;
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
  <info>+ mongodb</>
  <info>+ elasticsearch</>

自定义结构: <info>必须为 JSON 格式</>

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

        $manager = Factory::newManager();

        if ($manager->exists($service['name'])) {
            $this->error(sprintf('服务名称 %s 已注册', $service['name']));
            return 0;
        }

        if (($service['description'] = $input->getArgument('description')) === null) {
            $service['description'] = $this->ask('填写服务描述', '');
        }

        if (($service['engine'] = $input->getArgument('engine')) === null) {
            $service['engine'] = $this->choice(
                '选择服务引擎',
                ['log', 'trace', 'stats'],
                'log'
            );
        }

        if (($service['backend'] = $input->getArgument('backend')) === null) {
            $service['backend'] = $this->choice(
                '选择存储后端',
                ['mysql', 'mongodb', 'elasticsearch'],
                'mysql'
            );
        }

        if (($schema_path = $input->getOption('schema')) !== null) {
            if (! file_exists($schema_path)) {
                $this->error(sprintf('自定义数据结构文件 %s 未找到', $schema_path));
                return 0;
            }

            if (($json = file_get_contents($schema_path)) !== false) {
                try {
                    $service['schema'] = Json::decode($json);
                } catch (JsonException $e) {
                    $this->error(
                        sprintf('自定义数据结构文件 %s 无法解析: %s', $schema_path, $e->getMessage())
                    );
                    return 0;
                }
            }
        }

        $this->result('注册服务 <label>%s</> ', $manager->register($service));
        $this->newLine();

        return 0;
    }
}
