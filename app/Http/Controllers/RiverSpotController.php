<?php

namespace App\Http\Controllers;

use App\Models\RiverSpot;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RiverSpotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RiverSpot  $riverSpot
     * @return \Illuminate\Http\Response
     */
    public function show(RiverSpot $riverSpot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RiverSpot  $riverSpot
     * @return \Illuminate\Http\Response
     */
    public function edit(RiverSpot $riverSpot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RiverSpot  $riverSpot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RiverSpot $riverSpot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RiverSpot  $riverSpot
     * @return \Illuminate\Http\Response
     */
    public function destroy(RiverSpot $riverSpot)
    {
        //
    }

    public function convert_excel_to_db()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("coba.xlsx");
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
                $date = $val = $spreadsheet->getActiveSheet()
                ->getCell('E'.$i)->getValue();
                $water_level = $val = $spreadsheet->getActiveSheet()
                ->getCell('F'.$i)->getValue();
                $water_status = $val = $spreadsheet->getActiveSheet()
                ->getCell('G'.$i)->getValue();
                $id = $val = $spreadsheet->getActiveSheet()
                ->getCell('H'.$i)->getValue();
                if($date != null){
                    $data = RiverSpot::firstOrNew(['id'=>$id]);
                    $data->name = $name;
                    $data->date = $date;
                    $data->water_level = $water_level;
                    $data->water_status = $water_status;
                    $data->save();
                }
            }

        }
        return "berhasil";
        // return response()->json($val);
        // foreach ($worksheet->getRowIterator() as $row) {
        //     $cellIterator = $row->getCellIterator();
        //     foreach ($cellIterator as $cell) {
        //         $cell = $cell->getValue(); // Not sure what column this is looping through
        //     }
        // }
    }
}
