<?php

namespace Cache;

use Dpeuscher\Util\Cache\CacheReturner;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class CacheReturnerTest
 * @covers \Dpeuscher\Util\Cache\CacheReturner
 */
class CacheReturnerTest extends TestCase
{
    public function testReturn()
    {
        $cache = new CacheReturner($this->getBasicCache(), $this->getBasicLogger(0));

        $this->assertSame(1, $cache->return('test', function () {
            return 1;
        }));
    }

    public function testReturnCached()
    {
        $cache = new CacheReturner($this->getBasicCache(), $this->getBasicLogger(0));

        $i = 0;
        $cache->return('test', function () use (&$i) {
            return ++$i;
        });
        $this->assertSame(1, $cache->return('test', function () use (&$i) {
            return ++$i;
        }));
    }

    public function testReturnLogsExceptionOnWrongKeyAndFallsBackToNonCachedCall()
    {
        $cache = new CacheReturner($this->getBasicCache(), $this->getBasicLogger(2));

        $i = 0;
        $cache->return(\chr(8), function () use (&$i) {
            return ++$i;
        });
        $this->assertSame(2, $cache->return(\chr(8), function () use (&$i) {
            return ++$i;
        }));
    }

    private function getBasicCache(): CacheInterface
    {
        return new class implements CacheInterface
        {
            /**
             * @var array
             */
            private $array;

            /**
             *  constructor.
             *
             * @param array $array
             */
            public function __construct(array $array = [])
            {
                $this->array = $array;
            }

            public function get($key, $default = null)
            {
                $this->validateKey($key);
                return $this->array[$key];
            }

            public function set($key, $value, $ttl = null)
            {
                $this->validateKey($key);
                $this->array[$key] = $value;
            }

            public function delete($key)
            {
                throw new \RuntimeException('Not implemented');
            }

            public function clear()
            {
                throw new \RuntimeException('Not implemented');
            }

            public function getMultiple($keys, $default = null)
            {
                throw new \RuntimeException('Not implemented');
            }

            public function setMultiple($values, $ttl = null)
            {
                throw new \RuntimeException('Not implemented');
            }

            public function deleteMultiple($keys)
            {
                throw new \RuntimeException('Not implemented');
            }

            public function has($key)
            {
                $this->validateKey($key);
                return isset($this->array[$key]);
            }

            /**
             * @param $key
             */
            private function validateKey($key): void
            {
                if (preg_match('/[\x00-\x1F]/', $key)) {
                    throw new class extends \RuntimeException implements InvalidArgumentException
                    {
                    };
                }
            }
        };
    }

    private function getBasicLogger(int $count): LoggerInterface
    {
        $mock = $this->getMockBuilder(LoggerInterface::class)->setMethods([
            'emergency',
            'alert',
            'critical',
            'error',
            'warning',
            'notice',
            'info',
            'debug',
            'log',
        ])->getMock();
        $mock->expects($this->exactly($count))->method('warning')->withAnyParameters()
            ->willReturnCallback(function ($message) {
                $this->assertContains('Used invalid key as cache key', $message);
                $this->assertContains('Used invalid key as cache key', $message);
            });
        /** @var LoggerInterface $mock */
        return $mock;
    }
}
