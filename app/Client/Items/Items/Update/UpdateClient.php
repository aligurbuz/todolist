<?php 

namespace App\Client\Items\Items\Update;

use App\Client\Client;
use App\Client\ClientAutoGeneratorTrait;
use App\Models\Item;

class UpdateClient extends Client
{
	use GeneratorTrait;
	use ClientAutoGeneratorTrait;

	/**
	 * get capsule for client
	 *
	 * @var array
	 */
	protected array $capsule = [];

	/**
	 * get model entity validation
	 *
	 * @var array|string[]
	 */
	protected array $model = [Item::class];

	/**
	 * get rule for client
	 *
	 * @var array
	 */
	protected array $rule = ['item_code' => 'required|integer'];
}
