<?php

namespace App\Repositories;

use App\Services\Client;
use App\Exceptions\Exception;
use Illuminate\Database\Eloquent\Builder;

class EloquentRepository
{
    /**
     * get data for user model
     *
     * @return array
     */
    public function get() : array
    {
        return static::$model::instruction()->withQuery()
            ->selectQuery()->orderByQuery()->filterQuery()->simplePaginate(20)->toArray();
    }

    /**
     * create data for user model
     *
     * @param array $data
     * @return array|object
     */
    public function create(array $data = []): array|object
    {
        $data = count($data) ? $data : Client::data();

        $list = [];

        try {
            foreach ($data as $value){
                $list[] = static::$model::create($value);
            }

            return $list;
        }
        catch (\Exception $exception){
            return Exception::customException($exception->getPrevious()->getMessage());
        }
    }

    /**
     * update data for user model
     *
     * @param array $data
     * @param bool $id
     * @return array|object
     */
    public function update(array $data = [],$id = true): array|object
    {
        $clientData = count($data) ? $data : Client::data();

        $queryList = [];

        foreach ($clientData as $data){
            $baseQuery = static::$model::where(function(Builder $builder) use($data,$id){
                if(isset($data['id']) || $id === true){
                    $builder->where('id',intval(($data['id'] ?? 0)));
                }
            });

            $update = $baseQuery->update($data);

            if($update=='0'){
                return Exception::updateException();
            }

            $queryList[] = $baseQuery->get()->toArray();
        }

        return $queryList;

    }

    /**
     * @param $id
     * @return array
     */
    public function find(int $id) : array
    {
        return static::$model::find($id)->toArray();
    }
}