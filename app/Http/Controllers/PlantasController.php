<?php

namespace App\Http\Controllers;

use App\Models\MonitoringPlans;
use App\Models\Plantas;
use Illuminate\Http\Request;

class PlantasController extends Controller
{

    public function index () {
        try {
            $data = Plantas::returnAllPlants();
            
            return response()->json(['data' => $data]);
        
        } catch (\Exception $e) {
            return response (['error' => $e->getMessage()], 500);
        } 
    }

    public function destroy ($id) 
    {
        try {
            $data = Plantas::find($id);
            $data->delete();
            return response (['success' => 'Planta deletada com sucesso!'], 200);
        
        } catch (\Exception $e) {
            return response (['error' => $e->getMessage()], 500);
        } 
    }

    public function update (Request $request, $id) 
    {
        try {
            $data = Plantas::find($id);
            $data->status = $request->status;
            
            $data->save();
            return response (['success' => 'Planta atualizada com sucesso!'], 200);

        } catch (\Exception $e) {
            return response (['error' => $e->getMessage()], 500);
        }
    }

    public function show($id) 
    {
        try {
            $plant = Plantas::find($id);

            $logPlant = MonitoringPlans::where('id_plant', $id)->get();

            return response()->json([
                'status' => 1,
                'data' => $plant,
                'log_plant' => $logPlant
            ],200);

        } catch (\Exception $e) {
            return response (['error' => $e->getMessage()], 500);
        }
    }

    public function store () {
        try {
            $data = Plantas::create([
                'name_planta'   => request('name'),
                'description'   => request('description'),
                'interval_type' => request('interval_type'),
                'interval_time' => request('interval_time'),
            ]);

            return response (['success' => 'Planta criada com sucesso!'], 200);
        
        } catch (\Exception $e) {
            return response (['error' => $e->getMessage()], 500);
        } 
    } 
}
