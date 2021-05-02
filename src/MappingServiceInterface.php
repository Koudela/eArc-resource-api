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

use eArc\Data\Entity\Interfaces\EntityInterface;

interface MappingServiceInterface
{
    /**
     * @param string $fQCN
     * @return array<EntityInterface>
     */
    public function find(string $fQCN): array;
    public function read(string $fQCN, string $pk): EntityInterface;
    public function create(string $fQCN, array $values): EntityInterface;
    public function update(string $fQCN, string $pk, array $values): EntityInterface;
    public function delete(string $fQCN, string $pk): void;
}
