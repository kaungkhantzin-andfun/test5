<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return User::query();
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->phone,
            $user->email,
            $user->role,
            $user->address,
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'Email',
            'Role',
            'Address',
        ];
    }
}
