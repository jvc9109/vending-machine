<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure\Persistence\Doctrine;

use VendingMachine\Shared\Domain\Utils;
use VendingMachine\Shared\Domain\ValueObject\Uuid;
use VendingMachine\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use function Lambdish\Phunctional\last;

abstract class UuidType extends StringType implements DoctrineCustomType
{
    public function getName(): string
    {
        return self::customTypeName();
    }

    public static function customTypeName(): string
    {
        return Utils::toSnakeCase(str_replace('Type', '', last(explode('\\', static::class))));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = $this->typeClassName();

        return new $className($value);
    }

    abstract protected function typeClassName(): string;

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform)
    {
        return $value instanceof Uuid ? $value->value() : $value;
    }
}
