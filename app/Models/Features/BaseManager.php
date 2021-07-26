<?php

declare(strict_types=1);

namespace App\Models\Features;

use App\Constants;
use App\Services\Db;
use Illuminate\Support\Str;
use App\Services\AppContainer;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Trait BaseManager
 * @property object localization
 * @package App\Models\Features
 */
trait BaseManager
{
    use ScopeManager,GeneralAppends;

    /**
     * @var array|string[]
     */
    protected array $autoModelAppends = [
        'created_at_human' => 'Displays the created_at value in diffForHumans format.',
        'updated_at_human' => 'Displays the updated_at value in diffForHumans format.'
    ];

    protected array $localizationWithQuery = [
        'localization' => [
            'foreignColumn' => 'localized_code',
            'localColumn'   => 'product_code',
            'table' => 'localizations',
            'description' => 'You can use localizations relation belonging to product data.',
            'repository' => 'localization',
        ],
    ];

    /**
     * BaseManager constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->fillable = Db::columns($this->getTable());
        $this->assignAppends();
        $this->withQueryConstructor();
        parent::__construct($attributes);
    }

    /**
     * model boot process
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    }

    /**
     * get eager loading constructor for localization
     *
     * @return void
     */
    protected function withQueryConstructor()
    {
        $this->withModelHandler();

        if(property_exists($this,'withQuery') && is_array($this->withQuery)){
            $this->withQuery = array_merge_recursive($this->withQuery,$this->localizationWithQuery);
        }
    }

    /**
     * get model relations
     *
     * @param string|null $model
     * @return void
     */
    public function getModelRelationsForCode(?string $model = null) : void
    {
        $modelName                  = $model ?? $this->getModelName();
        $relationCodes              = Db::relationCodes();
        $currentModelName           = ucfirst($modelName);
        $relationsAccordingToCode   = $relationCodes[getTableCode($modelName)] ?? [];

        foreach ($relationsAccordingToCode as $modelRelation){
            if(
                $modelRelation!==$currentModelName
                && $modelRelation!=='Localization'
            ){
                $modelNamespace = Constants::modelNamespace.'\\'.$modelRelation;
                if(Str::endsWith($modelRelation,'y')){
                    $withModelKey = substr(Str::camel($modelRelation),0,-1).'ies';
                }
                else{
                    $withModelKey = Str::camel($modelRelation).'s';
                }

                if(class_exists($modelNamespace) && !isset($this->withQuery[$withModelKey])){
                    $this->withQuery[$withModelKey] = [
                        'hasMany' => true,
                        'foreignColumn' => getTableCode($currentModelName),
                        'localColumn' => getTableCode($currentModelName),
                        'table' => $withModelKey,
                        'description' => 'You can use '.$withModelKey.' relation belonging to '.$currentModelName.' data.',
                        'repository' => Str::camel($modelRelation)
                    ];
                }

                $this->getModelRelationsForCode($modelRelation);
            }
        }
    }


    /**
     * get with model handler for model
     *
     * @return void
     */
    protected function withModelHandler()
    {
        $columns = Db::columns($this->getTable());

        $this->getModelRelationsForCode();

        foreach ($columns as $column){
            if(Str::endsWith($column,'_code')){
                $relationModel = Str::camel(str_replace('_code','',$column));

                if($relationModel!==$this->getModelName()){
                    $relationModelNamespace = Constants::modelNamespace.'\\'.Str::ucfirst($relationModel);

                    if(class_exists($relationModelNamespace)){
                        $relationTable = (new $relationModelNamespace)->getTable();

                        $this->withQuery[$relationModel] = [
                            'foreignColumn' => Str::snake($relationModel).'_code',
                            'localColumn' => Str::snake($relationModel).'_code',
                            'table' => $relationTable,
                            'description' => 'You can use '.$relationModel.' relation belonging to '.$this->getModelName().' data.',
                            'repository' => Str::camel($relationModel)
                        ];
                    }
                }
            }
        }

    }

    /**
     * get model name
     *
     * @return string
     */
    public function getModelName() : string
    {
        return getModelName(get_called_class());
    }

    /**
     * get repository object
     *
     * @return object
     */
    public function getRepository() : object
    {
        $model = $this->getModelName();
        return Repository::$model();
    }

    /**
     * get with queries for model
     *
     * @return mixed
     */
    public function getWithQueries() : mixed
    {
        return $this->withQuery;
    }

    /**
     * get with queries for model
     *
     * @return array
     */
    public function getWithValues() : array
    {
        $list = [];

        foreach ($this->getWithQueries() as $relation => $withQuery){
            $list[] = $relation;
        }

        return $list;
    }

    /**
     * get localization model
     *
     * @return HasOne
     */
    public function localization(): HasOne
    {
        return $this->getRepository()->withLocalization($this);
    }

    /**
     * set appends according to client
     *
     * @return void
     */
    public function assignAppends()
    {
        $list = [];
        $modelAppends = array_merge($this->autoModelAppends,($this->modelAppends ?? []));
        AppContainer::set('responseFormatterSupplement',['appends' => $modelAppends]);

        $clientAppends = (request()->query->all())['append'] ?? null;

        if(!is_null($clientAppends)){
            $appendsList = explode(',',$clientAppends);

            foreach ($appendsList as $item){
                if(isset($modelAppends[$item])){
                    $list[] = $item;
                }
            }
        }

        $this->setAppends($list);
    }

    /**
     * get __call method for base manager
     *
     * @param $name
     * @param array $args
     * @return mixed
     */
    public function __call($name,$args = [])
    {
        $queries = $this->getWithQueries();

        if(isset($queries[$name])){
            $withName = 'with'.Str::ucfirst($name);
            return $this->getRepository()->{$withName}($this);
        }

        return parent::__call($name,$args);
    }
}
