<?php

namespace Innoscripta\Domain\Auth\Repositories\Eloquent;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Innoscripta\Domain\Auth\Repositories\Contracts\UserRepository;
use Innoscripta\Domain\Auth\User;
use Orkhanahmadov\EloquentRepository\EloquentRepository;

class EloquentUserRepository extends EloquentRepository implements UserRepository
{
    /** @deprecated */
    public function stategroups($user_id)
    {
        return $this->entity::with(
            [
                'stategroups' => function ($query) {
                    /**@var Builder $query */
                    $query
                        ->orderBy('order', 'asc')
                        ->orderBy('groupeName');
                },
            ]
        )->select('id')->find($user_id)->stategroups;
    }

    /** @deprecated */
    public function currentUser()
    {
        return Auth::user();
    }

    /**
     * @return mixed
     */
    protected function entity()
    {
        return User::class;
    }
}
