<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class exportdata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tesis:exportdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $db = DB::table('river_spots')
    ->select(
        // DB::raw("YEAR(tanggal) as date_year"),
        // DB::raw("MONTH(tanggal) as date_month"),
        // DB::raw('DATE(tanggal) as date'),
        "name",
        // DB::raw("COUNT(jumlah) as jumlah")
    )
    ->groupBy('name')
    ->get();
    $this->info($db);
    // return 0;

    foreach ($db as $index => $data) {
        # code...
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()
        ->getCell('A1')
        ->setValue('tanggal,water_level');
        $items = DB::table('river_spots')
        ->where('name',$data->name)
        ->select(
            "name",
            DB::raw("DATE(date) as date"),
            "water_level"
        )
        ->groupBy("name","date","water_level")
        ->get();
        // $this->info($items);
        // return 0;
        foreach ($items as $i => $item) {
            # code...
            $index = $i+2;
            $spreadsheet->getActiveSheet()
            ->getCell('A'.$index)
            ->setValue($item->date.','.$item->water_level);
        }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->save($item->name.".csv");
    }

        return 0;
    }
}
