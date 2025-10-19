<?php
/**
 * Copyright © NativeMind. All rights reserved.
 */
declare(strict_types=1);

namespace NativeMind\Marketplace\Api\Data;

/**
 * Marketplace statistics interface
 */
interface StatsInterface
{
    /**
     * Get total sellers count
     *
     * @return int
     */
    public function getTotalSellers(): int;

    /**
     * Set total sellers count
     *
     * @param int $count
     * @return $this
     */
    public function setTotalSellers(int $count): self;

    /**
     * Get pending sellers count
     *
     * @return int
     */
    public function getPendingSellers(): int;

    /**
     * Set pending sellers count
     *
     * @param int $count
     * @return $this
     */
    public function setPendingSellers(int $count): self;

    /**
     * Get approved sellers count
     *
     * @return int
     */
    public function getApprovedSellers(): int;

    /**
     * Set approved sellers count
     *
     * @param int $count
     * @return $this
     */
    public function setApprovedSellers(int $count): self;

    /**
     * Get total products count
     *
     * @return int
     */
    public function getTotalProducts(): int;

    /**
     * Set total products count
     *
     * @param int $count
     * @return $this
     */
    public function setTotalProducts(int $count): self;

    /**
     * Get total reviews count
     *
     * @return int
     */
    public function getTotalReviews(): int;

    /**
     * Set total reviews count
     *
     * @param int $count
     * @return $this
     */
    public function setTotalReviews(int $count): self;

    /**
     * Get total messages count
     *
     * @return int
     */
    public function getTotalMessages(): int;

    /**
     * Set total messages count
     *
     * @param int $count
     * @return $this
     */
    public function setTotalMessages(int $count): self;

    /**
     * Get average seller rating
     *
     * @return float
     */
    public function getAverageRating(): float;

    /**
     * Set average seller rating
     *
     * @param float $rating
     * @return $this
     */
    public function setAverageRating(float $rating): self;
}

