<?php

namespace Enraiged\Users\Tables\Builders;

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
    protected string $template = __DIR__.'/../Templates/user-index.json';

    /**
     *  Determine whether or not a provided object is secure.
     *
     *  @param  array|object  $object
     *  @param  \Illuminate\Database\Eloquent\Model|null  $model = null
     *  @return bool
     *
    protected function assertSecure($object, $model = null): bool
    {
        return true;
    }*/

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
    public function filterActive($param)
    {
        $active = filter_var($param, FILTER_VALIDATE_BOOLEAN);

        $this->builder
            ->where('users.is_active', $active);
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
            ->where('users.is_hidden', false);

        if (!$this->request()->hasFilter('active')) {
            $builder->where('users.is_active', true);
        }

        if (!$this->request()->hasFilter('deleted')) {
            $builder->whereNull('users.deleted_at');
        }

        return $builder;
    }
}
