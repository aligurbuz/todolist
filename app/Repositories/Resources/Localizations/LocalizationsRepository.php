<?php

declare(strict_types=1);

namespace App\Repositories\Resources\Localizations;

use Illuminate\Support\Str;
use App\Models\Localization;
use App\Repositories\EloquentRepository;
use App\Repositories\Resources\Localizations\Contracts\LocalizationsRepositoryContract;

class LocalizationsRepository extends EloquentRepository implements LocalizationsRepositoryContract
{
	/**
	 * get model name for repository
	 *
	 * @var string
	 */
	protected static string $model = Localization::class;

	/**
	 * get client ranges for repository
	 *
	 * @var array|string[]
	 */
	protected array $ranges = [];

    /**
     * get auto LocalizationsRepository scope method
     *
     * @param object|null $builder
     * @return object
     */
	public function localizationsRepository(?object $builder = null): object
	{
		return $this->apply($builder)->where('language_code',appLanguageCode());
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
     * finds data by localized_code column
     *
     * @param $localizedCode
     * @return LocalizationsRepositoryContract
     */
	public function localizedCode($localizedCode) : LocalizationsRepositoryContract
    {
        $this->repository = $this->instance()->where(Str::snake(__FUNCTION__),intval($localizedCode));

        return $this;
    }
}
