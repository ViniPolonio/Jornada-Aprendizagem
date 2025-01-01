<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 
        'name_planta',
        'descrition',
        'image_one',
        'image_two',
        'created_at',
        'updated_at',
        'deleted_at',
        'interval_type',
        'interval_time',
    ];

    public function lastMonitoringPlan()
    {
        return $this->hasOne(MonitoringPlans::class, 'id_plant')->latestOfMany();
    }

    public static function returnAllPlants()
    {
        try {
            $data = Plantas::whereNull('deleted_at')
                ->with(['lastMonitoringPlan' => function ($query) {
                    $query->select(
                        'monitoring_plans.id', 
                        'monitoring_plans.id_plant', 
                        'monitoring_plans.temperatura', 
                        'monitoring_plans.umidade', 
                        'monitoring_plans.created_at'
                    );
                }])
                ->get();


            return $data;

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

}
