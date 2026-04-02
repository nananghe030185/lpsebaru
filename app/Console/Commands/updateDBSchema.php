<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class updateDBSchema extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-table-schema {tabel} {column}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Schema Tabel Database';

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'kabkot' => 'Masukan Nama Tabel ? ',
            'status' => 'Masukan Kolom ? ',
        ];
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tabel = $this->argument('tabel');
        $column = $this->argument('column');

        if(Schema::hasTable($tabel)){
            Schema::table($tabel, function (Blueprint $table) use ($tabel, $column) {
                if(Schema::hasColumn($tabel, $column)){
                    $table->string($column)->nullable();
                }
            });
        }
    }
}
