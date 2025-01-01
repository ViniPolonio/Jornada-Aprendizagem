<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Plantas;
use App\Models\MonitoringPlans;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class MonitoramentoPlantasCommand extends Command
{
    protected $signature = 'command:MonitoramentoPlantasCommand';

    protected $description = 'Monitora as plantas ativas e consulta dados no ASP32 quando o intervalo for atingido';

    public function handle()
    {
        try {
            $plantasAtivas = Plantas::where('status', 1)->get();
    
            foreach ($plantasAtivas as $planta) {
                $intervaloConfig = $this->calcularProximoIntervalo($planta);
    
                if ($intervaloConfig['deveExecutar']) {
                    $this->info("Consultando dados para a planta: {$planta->name_planta}");
    
                    $dadosAsp32 = $this->consultarDadosAsp32($planta);
    
                    MonitoringPlans::create([
                        'id_plant' => $planta->id,
                        'temperatura' => $dadosAsp32['temperatura'],
                        'umidade' => $dadosAsp32['umidade'],
                    ]);
    
                    $planta->update([
                        'updated_at' => Carbon::now(),
                    ]);
                } else {
                    $this->info("A planta {$planta->name_planta} não está no intervalo correto para consulta.");
                }
            }
        } catch (\Exception $exception) {
            dd($exception);
            $this->error("Erro ao executar o monitoramento das plantas: " . $exception->getMessage());
        }
    }

    protected function calcularProximoIntervalo(Plantas $planta)
    {
        $ultimoMonitoramento = $planta->updated_at;
        $intervaloTipo = $planta->interval_type; 
        $intervaloValor = $planta->interval_time; 

        $proximoMonitoramento = Carbon::parse($ultimoMonitoramento);

        switch ($intervaloTipo) {
            case 1:
                $proximoMonitoramento->addMinutes($intervaloValor);
                break;
            case 2:
                $proximoMonitoramento->addHours($intervaloValor);
                break;
            case 3:
                $proximoMonitoramento->addDays($intervaloValor);
                break;
            default:
                return ['deveExecutar' => false]; 
        }

        if (Carbon::now()->greaterThanOrEqualTo($proximoMonitoramento)) {
            return ['deveExecutar' => true];
        }
        return ['deveExecutar' => false];
    }

    protected function consultarDadosAsp32(Plantas $planta)
    {
        $esp32Ip = 'http://172.20.10.3';

        try {
            $response = Http::timeout(4)->get($esp32Ip . '/dados');
            dump("Procurando dados no asp32");
            if ($response->successful()) {
                $dados = $response->body();

                preg_match('/Temperatura:\s(\d+)/', $dados, $matchesTemp);
                preg_match('/Umidade:\s(\d+)/', $dados, $matchesHum);

                $temperatura = $matchesTemp[1] ?? null;
                $umidade = $matchesHum[1] ?? null;

                if ($temperatura !== null && $umidade !== null) {
                    dump($planta->id, $planta->name_planta, $temperatura, $umidade);
                    MonitoringPlans::create([
                        'id_plant'    => $planta->id,
                        'temperatura' => $temperatura,
                        'umidade'     => $umidade,
                    ]);
                    $this->info("Dados salvos com sucesso para a planta: {$planta->name_planta}");
                } else {
                    $this->error("Dados inválidos recebidos do ESP32 para a planta: {$planta->name_planta}");
                }

                return [
                    'temperatura' => $temperatura,
                    'umidade'     => $umidade,
                ];
            }

            $this->error("Falha na comunicação com o ESP32 (Status: " . $response->status() . ")");
            return [
                'temperatura' => null,
                'umidade'     => null,
            ];
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            $this->error("Falha na comunicação com o ESP32: " . $e->getMessage());
            return [
                'temperatura' => null,
                'umidade'     => null,
            ];
        } catch (\Exception $e) {
            $this->error("Erro ao consultar dados do ESP32: " . $e->getMessage());
            return [
                'temperatura' => null,
                'umidade'     => null,
            ];
        }
    }

}
