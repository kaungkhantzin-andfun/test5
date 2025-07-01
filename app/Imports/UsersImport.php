<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\ImportFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Notifications\ImportHasFailedNotification;

class UsersImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnError,
    SkipsOnFailure,
    SkipsEmptyRows,
    ShouldQueue,
    WithEvents,
    WithChunkReading,
    WithBatchInserts
{
    use Importable, SkipsErrors, SkipsFailures;

    public function __construct(private User $importedBy)
    {
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|string',
            '*.email' => 'required|email|unique:users,email',
        ];
    }

    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'slug' => Str::slug($row['name']) . '-' . uniqid(),
            'phone' => $row['phone'],
            'email' => $row['email'],
            // 'role' => $row['role'],
            'role' => 'real-estate-agent',
            'status' => 'imported',
            'password' => Hash::make(Str::random(18)),
            'address' => $row['address'],
        ]);
    }

    public function batchSize(): int
    {
        return 10;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $event) {
                $this->importedBy->notify(new ImportHasFailedNotification);
            },
        ];
    }
}
