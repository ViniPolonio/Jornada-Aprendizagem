<?php

namespace App\Http\Controllers;

use App\Models\Plantas;
use Illuminate\Http\Request;
use App\Models\MonitoringPlans;

class MonitoringPlansController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_plant'    => 'required|integer',
            'temperatura' => 'required|numeric',
            'umidade'     => 'required|numeric',
        ]);

        MonitoringPlans::create([
            'id_plant'    => $validated['id_plant'],
            'temperatura' => $validated['temperatura'],
            'umidade'     => $validated['umidade'],
        ]);

        return response()->json(['message' => 'Dados salvos com sucesso!'], 200);
    }

    public function returnDataPlant($id, Request $request) {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $name_planta = Plantas::find($id)->name_planta;

            if (!$startDate || !$endDate) {
                return response(['error' => 'As datas de início e término são obrigatórias.'], 400);
            }
            
            \Carbon\Carbon::setLocale('pt_BR');
            $startDate = \Carbon\Carbon::parse($startDate);
            $endDate = \Carbon\Carbon::parse($endDate);

            // $data = MonitoringPlans::where('id_plant', $id)->orderByDesc('created_at')->get();

            $data = MonitoringPlans::where('id_plant', $id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
    
            return response()->json(['status' => 1,'name_planta' => $name_planta, 'data' => $data]);
    
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
