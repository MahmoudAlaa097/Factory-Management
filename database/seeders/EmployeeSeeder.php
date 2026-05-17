<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Employee;
use App\Models\Management;
use App\Models\User;

class EmployeeSeeder extends RelationalSeeder
{
    protected string $jsonFile = 'employees.json';

    public function run(): void
    {
        $data        = $this->loadJson();
        $users       = User::all()->keyBy('username');
        $managements = Management::all()->keyBy(fn($m) => $m->type->value);
        $divisions   = Division::all()->keyBy('name');

        collect($data)->each(function ($record) use ($users, $managements, $divisions) {

            $user = !empty($record['username'])
                ? $users->get($record['username'])
                : null;

            $division = !empty($record['division'])
                ? $divisions->get($record['division'])
                : null;

            Employee::create([
                'user_id'       => $user?->id,
                'management_id' => $managements[$record['management']]->id,
                'division_id'   => $division?->id,
                'name'          => $record['name'],
                'code'          => $record['code'],
                'role'          => $record['role'],
                'is_active'     => true,
            ]);

            if ($user) {
                $user->assignRole($record['role']);
            }
        });
    }
}
