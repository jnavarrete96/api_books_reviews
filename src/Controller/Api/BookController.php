<?php

namespace App\Controller\Api;

use App\Dtos\BookDto;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/api/books', name: 'api_books_list', methods: ['GET'])]
    public function list(BookRepository $bookRepository): JsonResponse
    {
        $books = $bookRepository->findBooksWithAverageRating();

        $result = array_map(
            fn (array $row) => new BookDto(
                title: $row['title'],
                author: $row['author'],
                publishedYear: (int) $row['published_year'],
                averageRating: $row['average_rating'] !== null
                    ? (float) $row['average_rating']
                    : null
            ),
            $books
        );

        return $this->json($result);
    }
}
