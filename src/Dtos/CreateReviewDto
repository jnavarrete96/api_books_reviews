<?php

namespace App\Dtos;

use Symfony\Component\Validator\Constraints as Assert;

class CreateReviewDto
{
    public function __construct(
        #[Assert\NotNull(message: 'book_id es obligatorio')]
        #[Assert\Type(type: 'integer', message: 'book_id debe ser un entero')]
        public readonly ?int $bookId,

        #[Assert\NotNull(message: 'rating es obligatorio')]
        #[Assert\Type(type: 'integer', message: 'rating debe ser un entero')]
        #[Assert\Range(
            min: 1,
            max: 5,
            notInRangeMessage: 'rating debe estar entre {{ min }} y {{ max }}'
        )]
        public readonly ?int $rating,

        #[Assert\NotBlank(message: 'comment no puede estar vacío')]
        public readonly ?string $comment
    ) {}
}
