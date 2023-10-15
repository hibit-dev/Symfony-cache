<?php

namespace App\Repository\Cache;

use App\Repository\UserRepositoryInterface;
use App\Repository\Redis\RedisClientInterface;

use Symfony\Component\Cache\Adapter\RedisTagAwareAdapter;

class UserRepository implements UserRepositoryInterface
{
    private RedisTagAwareAdapter $cache;
    private UserRepositoryInterface $databaseRepository;

    const CACHE_PREFIX = 'user_';
    const CACHE_SECONDS_TTL = 10;
    const CACHE_TAG = 'users';

    public function __construct(
        RedisClientInterface $redisClient,
        UserRepositoryInterface $databaseRepository,
    ) {
        // Init Redis adapter for cache
        $this->cache = new RedisTagAwareAdapter(
            $redisClient->client(),
            self::CACHE_PREFIX,
            self::CACHE_SECONDS_TTL
        );

        // Set the fallback repository
        $this->databaseRepository = $databaseRepository;
    }

    public function getById(int $userId): string
    {
        $userFromCache = $this->cache->getItem($userId);

        if ($userFromCache->isHit()) {
            return $userFromCache->get(); // Cached data
        }

        $userFromDatabase = $this->databaseRepository->getById($userId);

        // Save cache for future requests
        $userFromCache->set($userFromDatabase)->tag(self::CACHE_TAG);
        $this->cache->save($userFromCache);

        return $userFromDatabase;
    }
}