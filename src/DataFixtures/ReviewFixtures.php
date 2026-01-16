<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $reviews = [
            [$this->getReference(BookFixtures::BOOK_ART, Book::class), 5, 'Libro fundamental'],
            [$this->getReference(BookFixtures::BOOK_ART, Book::class), 4, 'Muy completo pero complejo'],
            [$this->getReference(BookFixtures::BOOK_ART, Book::class), 5, 'Obligatorio para programadores'],

            [$this->getReference(BookFixtures::BOOK_CLEAN, Book::class), 5, 'Excelente guía de buenas prácticas'],
            [$this->getReference(BookFixtures::BOOK_CLEAN, Book::class), 4, 'Muy claro y práctico'],

            [$this->getReference(BookFixtures::BOOK_REFACTOR, Book::class), 3, 'Buen contenido pero denso'],
        ];

        foreach ($reviews as [$book, $rating, $comment]) {
            $review = (new Review())
                ->setBook($book)
                ->setRating($rating)
                ->setComment($comment);

            $manager->persist($review);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
        ];
    }
}
