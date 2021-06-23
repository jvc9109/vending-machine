<?php

declare(strict_types=1);


namespace VendingMachine\Shared\Domain;


interface Encoder
{
    public function encodePassword(string $plainPassword);

}
