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
use InvalidArgumentException;

class RouterService
{
    protected MappingServiceInterface $mappingService;

    public function __construct(MappingServiceInterface|null $mappingService = null)
    {
        $this->mappingService = $mappingService ?? di_get(MappingService::class);
    }

    public function route(int $urlPrefixLength = 0): string|null
    {
        $rawResourceString = substr(
            $_SERVER['REQUEST_URI'],
            $urlPrefixLength,
            strpos($_SERVER['REQUEST_URI'], '?')-$urlPrefixLength
        );

        $resource = trim(str_replace('/', '\\', $rawResourceString), '\\');

        [$fQCN, $pk] = explode('\\-\\', $resource, 2);

        parse_str(file_get_contents('php://input'), $values);

        return $this->action($_SERVER['REQUEST_METHOD'], $fQCN, $pk, $values);
    }

    protected function action(string $requestMethod, string $fQCN, string|null $pk, array $values): string|null
    {
        return is_null($pk) ? $this->actionAll($requestMethod, $fQCN, $values) : $this->actionOne($requestMethod, $fQCN, $pk, $values);
    }

    protected function actionOne(string $requestMethod, string $fQCN, string $pk, array $values): string|null
    {
        $entity = null;

        switch ($requestMethod) {
            case 'GET':
                $entity = $this->mappingService->read($fQCN, $pk);
                break;
            case 'POST':
                $entity = $this->mappingService->create($fQCN, $values);
                break;
            case 'PUT':
            case 'PATCH':
                $entity = $this->mappingService->update($fQCN, $pk, $values);
                break;
            case 'DELETE':
                $this->mappingService->delete($fQCN, $pk);
                break;
            default: throw new InvalidArgumentException();
        }

        if (!array_key_exists('_template', $values)) {
            return null;
        }

        if (is_null($entity)) {
            return $this->actionAll('GET', $fQCN, $values);
        }

        if ($values['_template'] === 'json') {
            $castService = di_get(CastService::class);

            return json_encode($castService->castSimple($entity, [], $castService->generateMapping($entity)));
        }

        return (string) $values['template']($entity);
    }

    protected function actionAll(string $requestMethod, string $fQCN, array $values): string|null
    {
       if ($requestMethod !== 'GET') {
           throw new InvalidArgumentException();
       }

       if (!array_key_exists('_template', $values)) {
           return null;
       }

        $castService = di_get(CastService::class);
        $entities = $this->mappingService->find($fQCN);

        if ($values['_template'] === 'json') {
            foreach ($entities as $key => $entity) {
                $entities[$key] = $castService->castSimple($entity, [], $castService->generateMapping($entity));
            }

            return json_encode($entities);
        }

        return (string) $values['_template']($entities);
    }
}
