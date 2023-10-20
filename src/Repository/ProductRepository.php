<?php

namespace App\Repository;

use App\Entity\Product;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry   )
    {
        parent::__construct($registry, Product::class);


    }


	public function findProductsByCategory( $category, $orderBy = 'p.name', $limit = null, $offset = null)
	{
		$qb = $this->createQueryBuilder('p')
			->innerJoin('App\Entity\CategoryRelation', 'cr', 'WITH', 'p.id = cr.post_id')
			->where('cr.category_id = :category_id')
			->setParameter('category_id', $category->getId())
			->orderBy($orderBy);
		$qb->andWhere($qb->expr()->notLike(   'p.stock_status', $qb->expr()->literal('outofstock')));

		if ($limit !== null) {
			$qb->setMaxResults($limit);
		}

		if ($offset !== null) {
			$qb->setFirstResult($offset);
		}

		return $qb->getQuery()->getResult();
	}

//    /**
//     * @return Product[] Returns an array of Product objects
//     */

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
