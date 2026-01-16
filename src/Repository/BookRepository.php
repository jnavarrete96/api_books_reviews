<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * Devuelve libros con su rating promedio calculado en DB
     */
    public function findBooksWithAverageRating(): array
    {
        return $this->createQueryBuilder('b')
            ->select(
                'b.title AS title',
                'b.author AS author',
                'b.publishedYear AS published_year',
                'ROUND(AVG(r.rating), 2) AS average_rating'
            )
            ->leftJoin('b.reviews', 'r')
            ->groupBy('b.id')
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
