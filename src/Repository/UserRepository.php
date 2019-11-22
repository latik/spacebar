<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|User find($id, $lockMode = null, $lockVersion = null)
 * @method null|User findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function store(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function remove($user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}
