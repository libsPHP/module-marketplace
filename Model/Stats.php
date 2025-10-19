<?php
/**
 * Copyright © NativeMind. All rights reserved.
 */
declare(strict_types=1);

namespace NativeMind\Marketplace\Model;

use NativeMind\Marketplace\Api\Data\StatsInterface;

/**
 * Marketplace statistics model
 */
class Stats implements StatsInterface
{
    /**
     * @var int
     */
    private $totalSellers = 0;

    /**
     * @var int
     */
    private $pendingSellers = 0;

    /**
     * @var int
     */
    private $approvedSellers = 0;

    /**
     * @var int
     */
    private $totalProducts = 0;

    /**
     * @var int
     */
    private $totalReviews = 0;

    /**
     * @var int
     */
    private $totalMessages = 0;

    /**
     * @var float
     */
    private $averageRating = 0.0;

    /**
     * @inheritdoc
     */
    public function getTotalSellers(): int
    {
        return $this->totalSellers;
    }

    /**
     * @inheritdoc
     */
    public function setTotalSellers(int $count): StatsInterface
    {
        $this->totalSellers = $count;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPendingSellers(): int
    {
        return $this->pendingSellers;
    }

    /**
     * @inheritdoc
     */
    public function setPendingSellers(int $count): StatsInterface
    {
        $this->pendingSellers = $count;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getApprovedSellers(): int
    {
        return $this->approvedSellers;
    }

    /**
     * @inheritdoc
     */
    public function setApprovedSellers(int $count): StatsInterface
    {
        $this->approvedSellers = $count;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTotalProducts(): int
    {
        return $this->totalProducts;
    }

    /**
     * @inheritdoc
     */
    public function setTotalProducts(int $count): StatsInterface
    {
        $this->totalProducts = $count;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTotalReviews(): int
    {
        return $this->totalReviews;
    }

    /**
     * @inheritdoc
     */
    public function setTotalReviews(int $count): StatsInterface
    {
        $this->totalReviews = $count;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTotalMessages(): int
    {
        return $this->totalMessages;
    }

    /**
     * @inheritdoc
     */
    public function setTotalMessages(int $count): StatsInterface
    {
        $this->totalMessages = $count;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAverageRating(): float
    {
        return $this->averageRating;
    }

    /**
     * @inheritdoc
     */
    public function setAverageRating(float $rating): StatsInterface
    {
        $this->averageRating = $rating;
        return $this;
    }
}

