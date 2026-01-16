<?php

namespace App\Dtos;

class BookDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $author,
        public readonly int $publishedYear,
        public readonly ?float $averageRating
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            author: $data['author'],
            publishedYear: (int) $data['published_year'],
            averageRating: $data['average_rating'] !== null
                ? (float) $data['average_rating']
                : null
        );
    }
}
