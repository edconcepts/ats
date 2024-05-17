<?php

namespace App\Settings;

/**
 * This class has the functions to define options for the HasOrder trait.
 *
 * @class OrderOptions
 */
class OrderOptions
{
    // Sensible defaults
    protected string $orderColumn = 'order';

    protected ?string $parentColumn = null;

    protected bool $orderOnCreate = true;

    protected bool $fixOrderOnDelete = true;

    protected int $startOrderFrom = 0;

    public function getOrderColumn(): string
    {
        return $this->orderColumn;
    }

    public function setOrderColumn(string $column): self
    {
        $this->orderColumn = $column;

        return $this;
    }

    public function getParentColumn(): ?string
    {
        return $this->parentColumn;
    }

    public function setParentColumn(string $column): self
    {
        $this->parentColumn = $column;

        return $this;
    }

    public function hasParentColumn(): bool
    {
        return ! is_null($this->getParentColumn());
    }

    public function shouldOrderOnCreate(): bool
    {
        return $this->orderOnCreate;
    }

    public function setOrderOnCreate(bool $should): self
    {
        $this->orderOnCreate = $should;

        return $this;
    }

    public function shouldFixOrderOnDelete(): bool
    {
        return $this->fixOrderOnDelete;
    }

    public function setFixOrderOnDelete(bool $should): self
    {
        $this->fixOrderOnDelete = $should;

        return $this;
    }

    public function startOrderFrom(): int
    {
        return $this->startOrderFrom;
    }

    public function setStartOrderFrom(int $from): self
    {
        $this->startOrderFrom = $from;

        return $this;
    }
}
