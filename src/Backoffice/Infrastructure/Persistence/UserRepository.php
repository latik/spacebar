<?php declare(strict_types=1);

namespace App\Backoffice\Infrastructure\Persistence;

use App\Backoffice\Domain\User\User;
use App\Backoffice\Domain\User\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function store(User $user)
    {
        $this->_em->persist($user);
    }

    public function remove(User $user)
    {
        $this->_em->remove($user);
    }
}
