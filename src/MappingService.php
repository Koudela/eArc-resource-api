<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 * resource api component
 *
 * @package earc/resource-api
 * @link https://github.com/Koudela/eArc-resource-api/
 * @copyright Copyright (c) 2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\ResourceApi;

use eArc\Cast\CastService;
use eArc\Data\Entity\Interfaces\EntityInterface;
use InvalidArgumentException;

class MappingService implements MappingServiceInterface
{
    protected CastService $castService;

    public function __construct()
    {
        $this->castService = di_get(CastService::class);
    }

    public function find(string $fQCN): array
    {
        return data_find($fQCN, []);
    }

    public function read(string $fQCN, string $pk): EntityInterface
    {
        return data_load($fQCN, $pk);
    }

    public function create(string $fQCN, array $values): EntityInterface
    {
        $entity = $this->castService->castSimple($values, $fQCN);

        if (!$entity instanceof EntityInterface) {
            throw new InvalidArgumentException(sprintf(
                '{306fa113-a39b-48b9-9a01-8edebacc1296} %s has to implement %s',
                $fQCN,
                EntityInterface::class
            ));
        }

        data_persist($entity);

        return $entity;
    }

    public function update(string $fQCN, string $pk, array $values): EntityInterface
    {
        $entity = data_load($fQCN, $pk);

        $this->castService->castSimple($values, $entity);

        data_persist($entity);

        return $entity;
    }

    public function delete(string $fQCN, string $pk): void
    {
        data_remove($fQCN, $pk);
    }
}
