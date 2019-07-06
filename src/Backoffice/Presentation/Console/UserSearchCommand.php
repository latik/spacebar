<?php

declare(strict_types=1);

namespace App\Backoffice\Presentation\Console;

use App\Backoffice\Application\Query\QueryObjectFactory;
use App\Backoffice\Application\QueryHandler\UserSearch;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class UserSearchCommand extends Command
{
    protected static $defaultName = 'UsersSearch';

    /**
     * @var QueryObjectFactory
     */
    private $queryObjectFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var UserSearch
     */
    private $userSearch;

    protected function configure()
    {
        $this
          ->setDescription('Search users')
          ->addArgument('searchString', InputArgument::REQUIRED, 'The search query string')
          ->addOption('format', null, InputOption::VALUE_REQUIRED, 'The output format', 'text');
    }

    public function __construct(
      QueryObjectFactory $queryObjectFactory,
      UserSearch $userSearch,
      SerializerInterface $serializer
    ) {
        parent::__construct(static::$defaultName);
        $this->queryObjectFactory = $queryObjectFactory;
        $this->userSearch = $userSearch;
        $this->serializer = $serializer;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     *
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $searchString = $input->getArgument('searchString');

        $data = [
          'filterByEmail' => $searchString,
        ];

        $queryObject = $this->queryObjectFactory::fromArray($data);

        $searchResult = ($this->userSearch)($queryObject);

        $io->write($this->serializer->serialize($searchResult, JsonEncoder::FORMAT));
    }
}
