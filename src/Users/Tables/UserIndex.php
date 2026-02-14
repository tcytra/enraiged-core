<?php

namespace Enraiged\Users\Tables;

use Enraiged\Users\Models\User;
use Enraiged\Users\Tables\Exporters\IndexExporter;
use Enraiged\Users\Tables\Resources\IndexResource;
use Enraiged\Tables\Builders\TableBuilder;
use Enraiged\Tables\Contracts\ProvidesDefaultSort;
use Enraiged\Tables\Contracts\ProvidesTableQuery;
use Illuminate\Database\Eloquent\Builder;

class UserIndex extends TableBuilder implements ProvidesDefaultSort, ProvidesTableQuery
{
    /** @var  string|object  The exporter service. */
    protected $exporter = IndexExporter::class;

    /** @var  string  The data model. */
    protected string $model = User::class;

    /** @var  string  The model resource. */
    protected $resource = IndexResource::class;

    /** @var  string  The template json file path. */
    protected string $template = __DIR__.'/Templates/user-index.json';

    /**
     *  Apply default sort criteria to this table builder.
     *
     *  @return void
     */
    public function defaultSort()
    {
        $this->builder
            ->orderBy('profiles.first_name')
            ->orderBy('profiles.last_name');
    }

    /**
     *  Filter the results against the active filter.
     *
     *  @param bool $param
     */
    public function filterStatus($param)
    {
        switch ($param) {
            case 'active':
                $this->builder
                    ->where('users.is_active', true)
                    ->whereNull('users.deleted_at');
                break;
            case 'inactive':
                $this->builder
                    ->where('users.is_active', false)
                    ->whereNull('users.deleted_at');
                break;
            case 'deleted':
                $this->builder
                    ->whereNotNull('users.deleted_at');
                break;
        }
    }

    /**
     *  Provide the initial query builder for this table.
     *
     *  @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $builder = $this->model::withTrashed()
            ->select('users.*')
            ->join('profiles', 'profiles.id', '=', 'users.profile_id')
            ->leftJoin('addresses', fn ($join)
                => $join->on('addresses.addressable_id', '=', 'profiles.id')
                    ->where('addresses.addressable_type', '=', 'profile'))
            ->leftJoin('countries', 'countries.id', '=', 'addresses.country_id')
            ->where('users.is_hidden', false);

        return $builder;
    }
}
