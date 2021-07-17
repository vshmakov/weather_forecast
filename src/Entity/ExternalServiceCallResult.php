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
     * @ORM\Column(type="text")
     */
    private string $url;

    /**
     * @ORM\Column(type="integer")
     */
    private int $statusCode;

    /**
     * @ORM\Column(type="text")
     */
    private string $content;

    public function __construct(string $url, int $statusCode, string $content)
    {
        $this->url = $url;
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

    public function getUrl(): string
    {
        return $this->url;
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
