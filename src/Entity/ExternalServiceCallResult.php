<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ExternalServiceCallResult
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $calledAt;

    /**
     * @ORM\Column(type="integer")
     */
    private int $statusCode;

    /**
     * @ORM\Column(type="text")
     */
    private string $content;

    public function __construct(int $statusCode, string $content)
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
        $this->calledAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalledAt(): DateTimeImmutable
    {
        return $this->calledAt;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}