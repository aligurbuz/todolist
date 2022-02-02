<?php 

declare(strict_types=1);

namespace App\Repositories\Resources\Items;

use App\Models\Item;
use App\Repositories\EloquentRepository;
use App\Repositories\Resources\Items\Contracts\ItemsRepositoryContract;

class ItemsRepository extends EloquentRepository implements ItemsRepositoryContract
{
	/**
	 * get model name for repository
	 *
	 * @var string
	 */
	protected static string $model = Item::class;

	/**
	 * get client ranges for repository
	 *
	 * @var array|string[]
	 */
	protected array $ranges = [];

	/**
	 * localization values for repository
	 *
	 * @var array|string[]
	 */
	protected array $localization = ['name'];

	/**
	 * hitter values for repository
	 *
	 * @var array|string[]
	 */
	protected array $hitter = [];

	/**
	 * denied eager loadings values for repository
	 *
	 * @var array
	 */
	protected array $deniedEagerLoadings = [];

	/**
	 * get auto eager loading values for repository
	 *
	 * @var array
	 */
	protected array $autoEagerLoadings = [];

	/**
	 * it contains columns to be used by groupBy method.
	 *
	 * @var array
	 */
	protected array $groupByFields = [];

	/**
	 * it contains aggregate methods to be used together groupBy method.
	 *
	 * @var array
	 */
	protected array $groupByProcessFields = [];

	/**
	 * get additional resource for repository
	 *
	 * @var bool
	 */
	protected bool $additionalResource = false;

	/**
	 * add post query for repository
	 *
	 * @var array
	 */
	protected array $addPostQueries = [];


	/**
	 * get auto ItemsRepository scope method
	 *
	 * @param object|null $builder
	 * @return object
	 */
	public function itemsRepository(?object $builder = null): object
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
	public function eventFireAfterCreate(array $result = [], array $clientData = []): void
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
	public function eventFireAfterUpdate(array $result = [], array $clientData = []): void
	{
		//
	}
}
