<?php

namespace App\Dto;

class TaskRead implements DTOInterface
{
    public function __construct(
        private ?int                $id = null,
        private ?string             $name = null,
        private ?int                $priority = null,
        private ?string             $description = null,
        private ?string             $category = null,
        private ?\DateTimeImmutable $createdAt = null,
        private ?\DateTimeImmutable $dueAt = null,
        private ?\DateTimeImmutable $startAt = null,
        private ?\DateTimeImmutable $endAt = null,
        private ?bool               $finished = false,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getDueAt(): ?\DateTimeImmutable
    {
        return $this->dueAt;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function getFinished(): ?bool
    {
        return $this->finished;
    }
}