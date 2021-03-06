<?php

declare(strict_types=1);

namespace App\Repositories\Resources\User;

use App\Models\User;
use App\Repositories\EloquentRepository;
use App\Repositories\Resources\User\Contracts\UserRepositoryContract;

/**
 * Class UserRepository
 * @package App\Repositories\Resources\User
 */
class UserRepository extends EloquentRepository implements UserRepositoryContract
{
    /**
     * @var string
     */
    protected static string $model = User::class;

    /**
     * @var array|string[]
     */
    protected array $ranges = [];

    /**
     * @var array
     */
    protected array $traits = [];

    /**
     * get auto user range method
     *
     * @param object|null $builder
     * @return object
     */
    public function userRepository(?object $builder = null) : object
    {
        return $this->apply($builder);
    }

    /**
     * the fired event after create method for repository
     *
     * @param array $result
     * @param array $clientData
     * @return void
     */
    public function eventFireAfterCreate(array $result = [],array $clientData = []): void
    {
        //
    }


    /**
     * the fired event after update method for repository
     *
     * @param array $result
     * @param array $clientData
     * @return void
     */
    public function eventFireAfterUpdate(array $result = [],array $clientData = []): void
    {
        //
    }

    /**
     * update data for user model
     *
     * @param array $data
     * @param bool $id
     * @return array
     */
    public function update(array $data = [], bool $id = true): array
    {
        return parent::update($data,false);
    }
}
