<?php

namespace Dpeuscher\Util\Cache;

use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * @category  util
 * @copyright Copyright (c) 2018 Dominik Peuscher
 */
class CacheReturner
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * CacheReturner constructor.
     *
     * @param CacheInterface $cache
     * @param LoggerInterface $logger
     */
    public function __construct(CacheInterface $cache, LoggerInterface $logger)
    {
        $this->cache = $cache;
        $this->logger = $logger;
    }

    public function return(string $key, callable $callback)
    {
        try {
            if ($this->cache->has(hash('sha256', $key))) {
                return $this->cache->get(hash('sha256', $key));
            }
        } catch (InvalidArgumentException $e) {
            $this->logger->warning('Used invalid key as cache key "' . $key . '" - handled as miss');
        }
        $result = $callback($key);
        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (!isset($e)) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $this->cache->set(hash('sha256', $key), $result);
        }
        return $result;
    }
}
