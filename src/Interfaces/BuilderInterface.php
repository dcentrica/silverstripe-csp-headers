<?php

namespace Firesphere\CSPHeaders\Interfaces;

use SilverStripe\Core\Validation\ValidationException;

/**
 * Interface Firesphere\CSPHeaders\Interfaces\BuilderInterface
 *
 * @package Firesphere\CSPHeaders
 *
 */
interface BuilderInterface
{
    /**
     * @param string $file
     * @param array $attributes
     * @param array $requirements
     * @param string $path
     * @return array
     * @throws ValidationException
     */
    public function buildTags($file, $attributes, array $requirements, string $path): array;

    /**
     * @param $requirements
     * @return array
     */
    public function getCustomTags($requirements): array;

    /**
     * @param array $requirements
     * @return void
     */
    public function getHeadTags(array &$requirements): void;
}
