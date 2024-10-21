<?php

namespace App\Http\Controllers;

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

        // Retornar resposta JSON
        return response()->json(['message' => 'Dados salvos com sucesso!'], 200);
    }

    public function returnDataPlant($id) {
        try {
            $data = MonitoringPlans::where('id_plant', $id)->get();
            return $data;
        
        } catch (\Exception $e) {
            return response (['error' => $e->getMessage()], 500);
        }
    }
}
