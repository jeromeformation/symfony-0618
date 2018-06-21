<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }


    /**
     * Récupère les produits avec le SQL
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findBySQL()
    {
        // On récupère PDO
        $pdo = $this->getEntityManager()->getConnection();

        // On met en place la requête
        $query = "
          SELECT * FROM product as p 
          WHERE p.nb_views > :nbViews
          ORDER BY p.created_at DESC
        ";
        $statement = $pdo->prepare($query);
        $statement->setFetchMode(
            \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,
            Product::class
        );
        $statement->execute([
            "nbViews" => 20
        ]);

        // On récupère les produits
        return $statement->fetchAll();
    }

    /**
     * Récupération des produits en DQL
     * @return Product[]
     */
    public function findByDQL(): array
    {
        // Création de la requête
        $query = $this->getEntityManager()->createQuery("
            SELECT p
            FROM App\Entity\Product as p
            WHERE p.nbViews > :nbViews
            ORDER BY p.createdAt DESC
        ")->setParameter("nbViews", 20);

        // Récupération des produits
        return $query->execute();
    }

    /**
     * Récupération des produits avec le QueryBuilder
     * @return Product[]
     */
    public function findByQueryBuilder(): array
    {
        // Création de la requête
        $query = $this->createQueryBuilder('p')
            ->where('p.nbViews > :nbViews')
            ->setParameter("nbViews", 20)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
        ;
        // Récupération des produits
        return $query->getResult();
    }

    /**
     * Récupère un produit avec son id ainsi que la catégorie associée
     * @param int $id
     * @return Product|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneWithCategory(int $id): ?Product
    {
        $query = $this->createQueryBuilder('p')
            ->innerJoin('p.categorie', 'c')
            ->addSelect('c')
            ->where('p.id = :id')->setParameter('id', $id)
            ->getQuery()
        ;

        return $query->getOneOrNullResult();
    }

    /**
     * Retourne la requête correspondant au findAll
     * @return Query
     */
    public function findAllQuery(): Query
    {
        return $this->createQueryBuilder('p')->getQuery();
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
