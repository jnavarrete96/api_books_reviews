<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public const BOOK_ART = 'book_art';
    public const BOOK_CLEAN = 'book_clean';
    public const BOOK_REFACTOR = 'book_refactor';

    public function load(ObjectManager $manager): void
    {
        $book1 = (new Book())
            ->setTitle('El Arte de Programar')
            ->setAuthor('Donald Knuth')
            ->setPublishedYear(1968);

        $book2 = (new Book())
            ->setTitle('Clean Code')
            ->setAuthor('Robert C. Martin')
            ->setPublishedYear(2008);

        $book3 = (new Book())
            ->setTitle('Refactoring')
            ->setAuthor('Martin Fowler')
            ->setPublishedYear(1999);

        $manager->persist($book1);
        $manager->persist($book2);
        $manager->persist($book3);
        $manager->flush();

        // Referencias para ReviewFixtures
        $this->addReference(self::BOOK_ART, $book1);
        $this->addReference(self::BOOK_CLEAN, $book2);
        $this->addReference(self::BOOK_REFACTOR, $book3);
    }
}
