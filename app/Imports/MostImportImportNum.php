<?php

namespace App\Imports;

use App\Models\number_matcher;
use App\Models\TestNumberEmirti;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;


class MostImportImportNum implements ToCollection,
    WithStartRow
    ,WithChunkReading,
    ShouldQueue

{
    /**
    * @param Collection $collection
    */
    public function startRow(): int
    {
        return 2;
    }
    public function collection(Collection $collection)
    {
        //

        // dd($collection);
        ini_set('max_execution_time', '3000'); //300 seconds = 5 minutes

        foreach ($collection as $row) {
            if($row['2'] == 'TRUE' || $row['2'] == TRUE){
                $prepaid = 'prepaid';
            }else{
                $prepaid = 'postpaid';
            }
            if($row['1'] == '' || $row['1'] == NULL){
                $customerType = 'blank';
            }else{
                $customerType = $row[0];
            }
            if($row['6'] == '' || $row['6'] == NULL){
                $plan = 'blank';
            }else{
                $plan = $row[6];
            }
            if (!number_matcher::where('number', '=', $row[7])->exists()) {
                // $num = number_matcher::where('number',$`)
                // if($numbe)
                number_matcher::create(
                    [
                        'number' => $row['7'],
                        // 'customerType' => $row['0'],
                        'plan' => $plan,
                        'number' => $row['7'],
                        'post_or_pre' => $prepaid,
                        'customerType' => $customerType,
                    ]
                );
                $zp = substr($row[7], 5);
                $pp = TestNumberEmirti::where('number', $zp)->first();
                $pp->five_five = 'found';
                $pp->save();
            }


        }
    }
    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
