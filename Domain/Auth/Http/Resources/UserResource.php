<?php

namespace Innoscripta\Domain\Auth\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Innoscripta\Domain\Auth\User;
use Innoscripta\Domain\HR\Http\Resources\Employee\EmployeeResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var User $this
         */
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'name' => $this->name,
            'role' => $this->role,
            'employee_id' => $this->employee_id, // todo: remove later
            //'employee' => new EmployeeResource($this->whenLoaded('employee')),
        ];
    }
}
