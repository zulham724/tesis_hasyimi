<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\RiverSpot;

class InputData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tesis:inputdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tesis Hasyimi';

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
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("C:/xampp/htdocs/tesis_hasyimi/public/Ciliwung.xlsx");
        // return $spreadsheet;
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
        $val = $spreadsheet->getActiveSheet()
        ->getCell('E2')->getValue();
        // return $val;
        for ($i=0; $i <$highestRow ; $i++) {
            # code...
            if($i != 1){
                $name = $spreadsheet->getActiveSheet()
                ->getCell('A'.$i)->getValue();
                $date = date('Y-m-d H:i:s',strtotime($spreadsheet->getActiveSheet()
                ->getCell('E'.$i)->getFormattedValue()));
                $water_level = $spreadsheet->getActiveSheet()
                ->getCell('F'.$i)->getValue();
                $water_status = $spreadsheet->getActiveSheet()
                ->getCell('G'.$i)->getValue();
                $id = $spreadsheet->getActiveSheet()
                ->getCell('H'.$i)->getValue();
                if($date && $water_level){
                    $data = RiverSpot::firstOrNew(['id'=>$id]);
                    $data->name = $name;
                    $data->date = $date;
                    $data->water_level = $water_level;
                    $data->water_status = $water_status;
                    $data->save();
                    $this->info("ID {$id} - Data dengan pintu air {$name} tanggal {$date} dengan tinggi air {$water_level} status {$water_status} berhasil disimpan");
                }
            }

        }
        return 0;
    }
}
