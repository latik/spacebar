<?php

declare(strict_types=1);

namespace App\Console\Command;

use Exception;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function json_encode;
use function random_int;

final class ArticleStatsCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'ArticleStats';

    protected function configure(): void
    {
        $this
            ->setDescription('Returns some article stats!')
            ->addArgument('slug', InputArgument::OPTIONAL, 'The article\'s slug')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'The output format', 'text')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
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
                $io->write(json_encode($data, JSON_THROW_ON_ERROR));

                break;
            default:
                throw new RuntimeException('What kind of crazy format is that!?');
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
