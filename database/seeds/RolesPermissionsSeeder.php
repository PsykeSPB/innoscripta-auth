<?php

use Illuminate\Database\Seeder;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->rolesAndPermissions() as $roleItem) {
            if (! $role = \Spatie\Permission\Models\Role::where('name', $roleItem['name'])->first()) {
                $role = \Spatie\Permission\Models\Role::create(['name' => $roleItem['name']]);
            }

            foreach ($roleItem['permissions'] as $permissionItem) {
                if (! $permission = \Spatie\Permission\Models\Permission::where('name', $permissionItem)->first()) {
                    $permission = \Spatie\Permission\Models\Permission::create(['name' => $permissionItem]);
                }
                $role->givePermissionTo($permission);
            }
        }
    }

    private function rolesAndPermissions()
    {
        return [
            [
                'name' => 'Admin',
                'permissions' => [
                    'hr.employees.read',
                    'hr.teams.read',
                    'hr.overview.read',
                    'hr.applicants.read',
                    'hr.birthdays.read',

                    'bonus.employee_capacity.read',

                    'revenue.dashboard.read',
                    'revenue.projects.read',
                    'revenue.revenue.read',
                    'revenue.values.read',
                    'revenue.project_logs.read',

                    'calendar.calendar.read',
                    'calendar.reservations.read',
                    'calendar.telephones.read',

                    'mc.info.read',
                    'mc.branches.read',
                    'mc.professors.read',
                    'mc.companies.read',

                    'todo.tasks.read',

                    'settings.users.read',
                    'settings.setup.read',
                    'settings.templates.read',

                    'bills.overview.read',

                    'bonus.dashboard.read',
                    'bonus.overview.read',

                    'documents.design.read',
                ]
            ],
            [
                'name' => 'CEO',
                'permissions' => [
                    'hr.employees.read',
                    'hr.teams.read',
                    'hr.overview.read',
                    'hr.applicants.read',
                    'hr.birthdays.read',

                    'bonus.employee_capacity.read',

                    'revenue.dashboard.read',
                    'revenue.projects.read',
                    'revenue.revenue.read',
                    'revenue.values.read',
                    'revenue.project_logs.read',

                    'calendar.calendar.read',
                    'calendar.reservations.read',
                    'calendar.telephones.read',

                    'mc.info.read',
                    'mc.branches.read',
                    'mc.professors.read',
                    'mc.companies.read',

                    'todo.tasks.read',

                    'settings.users.read',
                    'settings.setup.read',
                    'settings.templates.read',

                    'bills.overview.read',

                    'bonus.dashboard.read',
                    'bonus.overview.read',

                    'documents.design.read',
                ]
            ],
            [
                'name' => 'Team Leader',
                'permissions' => [
                    'revenue.projects.read',

                    'calendar.calendar.read',
                    'calendar.reservations.read',
                    'calendar.telephones.read',

                    'mc.info.read',
                    'mc.branches.read',
                    'mc.professors.read',
                    'mc.companies.read',

                    'todo.tasks.read',
                ]
            ],
            [
                'name' => 'Marketing',
                'permissions' => [
                    'revenue.projects.read',

                    'calendar.calendar.read',
                    'calendar.reservations.read',
                    'calendar.telephones.read',

                    'todo.tasks.read',
                ]
            ],
            [
                'name' => 'HR',
                'permissions' => [
                    'hr.employees.read',
                    'hr.teams.read',
                    'hr.overview.read',
                    'hr.applicants.read',
                    'hr.birthdays.read',

                    'calendar.calendar.read',
                    'calendar.reservations.read',
                    'calendar.telephones.read',

                    'todo.tasks.read',
                ]
            ],
            [
                'name' => 'Regular',
                'permissions' => [
                    'revenue.projects.read',

                    'calendar.calendar.read',
                    'calendar.reservations.read',
                    'calendar.telephones.read',

                    'mc.info.read',
                    'mc.branches.read',
                    'mc.professors.read',
                    'mc.companies.read',

                    'todo.tasks.read',
                ]
            ],
        ];
    }
}
