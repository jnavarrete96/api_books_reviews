<?php

namespace App\Controller\Api;

use App\Dtos\CreateReviewDto;
use App\Service\ReviewService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ReviewController extends AbstractController
{
    #[Route('/api/reviews', name: 'api_reviews_create', methods: ['POST'])]
    public function create(
        Request $request,
        ValidatorInterface $validator,
        ReviewService $reviewService
    ): JsonResponse {
        $status = JsonResponse::HTTP_CREATED;
        $payload = ['message' => 'Reseña creada correctamente'];

        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            $status = JsonResponse::HTTP_BAD_REQUEST;
            $payload = ['error' => 'JSON inválido'];
        } else {
            $dto = new CreateReviewDto(
                bookId: $data['book_id'] ?? null,
                rating: $data['rating'] ?? null,
                comment: $data['comment'] ?? null
            );

            $errors = $validator->validate($dto);

            if (count($errors) > 0) {
                $status = JsonResponse::HTTP_BAD_REQUEST;
                $payload = [
                    'errors' => array_map(
                        fn ($error) => $error->getMessage(),
                        iterator_to_array($errors)
                    )
                ];
            } else {
                try {
                    $reviewService->createReview($dto);
                } catch (BadRequestHttpException $e) {
                    $status = JsonResponse::HTTP_BAD_REQUEST;
                    $payload = ['error' => $e->getMessage()];
                }
            }
        }

        return $this->json($payload, $status);
    }
}
