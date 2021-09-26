<?php

use App\Status;
use Illuminate\Database\Seeder;

class CreateStatusTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'مدفوعة',
            'غير مدفوعة',
            'مدفوعة جزئيا'
        ];

        foreach($statuses as $status){

            Status::create([
                'name' => $status
            ]);
        }
    }
}
