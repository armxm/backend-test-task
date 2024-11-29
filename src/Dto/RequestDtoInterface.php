<?php

namespace App\Dto;

interface RequestDtoInterface
{
    public function getProduct(): int;
    public function getTaxNumber(): string;
    public function getCouponCode(): string;
}