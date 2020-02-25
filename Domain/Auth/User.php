<?php

namespace Innoscripta\Domain\Auth;

use App\Model\Note;
use App\Model\Page;
use App\Model\Stategroup;
use App\Models\FieldTranslation;
use App\Models\PermissionFieldGroup;
use App\Traits\ModelTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Innoscripta\Domain\HR\Employee;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, ModelTrait, HasRoles, HasApiTokens;

    const USER_ROLE_FOR_HR = 5;

    protected $fillable = [
        'username',
        'password',
        'role',
        'employee_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getRoleListAttribute()
    {
        return $this->roles()->pluck('name')->toArray();
    }

    public function getPermissionListAttribute()
    {
        return $this->getAllPermissions()->pluck('name')->toArray();
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * All permissions array
     * @return array
     */
    public function allFieldPermissions()
    {
        $fields_permission_list = [];
        $groups = $this->field_groups;
        if (!empty($groups)) {
            foreach ($groups as $group) {
                $fields = $group->fields;
                if (!empty($fields)) {
                    foreach ($fields as $field) {
                        $translation = FieldTranslation::withOldTable($field->table_name)
                            ->withOldField($field->name)
                            ->first();

                        $permission_name = optional($translation)->correct_field_name_for_permission ?? null;
                        $permission_name = (string)$permission_name;
                        if ($permission_name) {
                            $fields_permission_list[] = $permission_name . '.' . $field->rule_name;
                        }
                    }
                }
            }
        }
        return $fields_permission_list;
    }

    public function stategroups()
    {
        return $this->belongsToMany(Stategroup::class)->withPivot('status');
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class)->withPivot('can_view');
    }

    public function note()
    {
        return $this->hasOne(Note::class);
    }

    public function field_groups()
    {
        return $this->belongsToMany(PermissionFieldGroup::class, 'permission_field_group_for_user', 'user_id', 'field_group_id');
    }
}
