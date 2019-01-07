<?php declare(strict_types=1);

namespace App\Console\Command;

use Exception;
use function json_encode;
use function random_int;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ArticleStatsCommand extends Command
{
    protected static $defaultName = 'ArticleStats';

    protected function configure()
    {
        $this
          ->setDescription('Returns some article stats!')
          ->addArgument('slug', InputArgument::OPTIONAL, 'The article\'s slug')
          ->addOption('format', null, InputOption::VALUE_REQUIRED, 'The output format', 'text');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     *
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $slug = $input->getArgument('slug');

        $data = [
          'slug' => $slug,
          'hearts' => random_int(10, 100),
        ];

        switch ($input->getOption('format')) {
            case 'text':
                $rows = [];
                foreach ($data as $key => $val) {
                    $rows[] = [$key, $val];
                }
                $io->table(['Key', 'Value'], $rows);

                break;
            case 'json':
                $io->write(json_encode($data));

                break;
            default:
                throw new RuntimeException('What kind of crazy format is that!?');
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}