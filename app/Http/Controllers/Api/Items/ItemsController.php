<?php 

declare(strict_types=1);

namespace App\Http\Controllers\Api\Items;

use App\Client\Items\Items\Create\CreateClient;
use App\Client\Items\Items\Get\GetClient;
use App\Client\Items\Items\Update\UpdateClient;
use App\Http\Controllers\Api\ApiController;
use App\Repositories\Resources\Items\Contracts\ItemsRepositoryContract;

class ItemsController extends ApiController
{
	/**
	 * get items data
	 *
	 * @param GetClient $client
	 * @param ItemsRepositoryContract $itemsRepository
	 * @return array
	 */
	public function get(GetClient $client, ItemsRepositoryContract $itemsRepository): array
	{
		$client->handle();
		return $itemsRepository->get();
	}


	/**
	 * create items data
	 *
	 * @param CreateClient $client
	 * @param ItemsRepositoryContract $itemsRepository
	 * @return array|object
	 */
	public function create(CreateClient $client, ItemsRepositoryContract $itemsRepository): array|object
	{
		return $this->transaction(function() use($client,$itemsRepository) {
		    $client->handle();
		    return $itemsRepository->create();
		});
	}


	/**
	 * update items data
	 *
	 * @param UpdateClient $client
	 * @param ItemsRepositoryContract $itemsRepository
	 * @return array|object
	 */
	public function update(UpdateClient $client, ItemsRepositoryContract $itemsRepository): array|object
	{
		return $this->transaction(function() use($client,$itemsRepository) {
		    $client->handle();
		    return $itemsRepository->update();
		});
	}
}
