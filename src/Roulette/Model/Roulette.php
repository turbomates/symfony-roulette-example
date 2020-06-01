<?php
declare(strict_types=1);

namespace Roulette\Model;


interface Roulette
{
    public function spin(): Result;
}