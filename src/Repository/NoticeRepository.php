<?php

namespace App\Repository;

use App\Entity\Notice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notice>
 *
 * @method Notice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notice[]    findAll()
 * @method Notice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoticeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notice::class);
    }

    public function getActualNoticesById($id)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.expiration > CURRENT_TIMESTAMP() AND n.user = :id')
            ->setParameters(['id' => $id])
            ->getQuery()
            ->getResult()
        ;
    }

    public function getActualNotices()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT n FROM App:Notice n WHERE n.expiration > CURRENT_TIMESTAMP()'
        )->getResult();
    }

//    /**
//     * @return Notice[] Returns an array of Notice objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Notice
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
