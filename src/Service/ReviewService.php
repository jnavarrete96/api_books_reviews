<?php

namespace App\Service;

use App\Dtos\CreateReviewDto;
use App\Entity\Review;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ReviewService
{
    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function createReview(CreateReviewDto $dto): void
    {
        $book = $this->bookRepository->find($dto->bookId);

        if (!$book) {
            throw new BadRequestHttpException('El libro especificado no existe');
        }

        $review = new Review();
        $review->setBook($book);
        $review->setRating($dto->rating);
        $review->setComment($dto->comment);

        $this->entityManager->persist($review);
        $this->entityManager->flush();
    }
}
