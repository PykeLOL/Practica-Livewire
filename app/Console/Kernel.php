<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use App\Models\Futbol;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function () {
        //     // Obtener todos los futbols que tienen el estado en "true" y cuya fecha de expiración haya pasado
        //     $expiredFutbols = Futbol::where('status', true)
        //                             ->where('expiration_date', '<', Carbon::now())
        //                             ->get();

        //     // Actualizar el estado de los futbols a "false" si su fecha de expiración ha pasado
        //     foreach ($expiredFutbols as $futbol) {
        //         $futbol->status = false;
        //         $futbol->save();
        //     }
        // })->daily();
        $schedule->call(function () {
            // Obtener todos los futbols que tienen el estado en "true"
            $futbols = Futbol::where('status', true)->get();

            // Recorrer los futbols y actualizar el campo "status" a "false" si han pasado 2 minutos desde su creación
            foreach ($futbols as $futbol) {
                $createdAt = Carbon::parse($futbol->updated_at);
                $currentTime = Carbon::now();

                // Si han pasado 2 minutos desde la creación, actualiza el campo "status" a "false"
                if ($currentTime->diffInMinutes($createdAt) >= 2) {
                    $futbol->status = false;
                    $futbol->save();
                }
            }
        })->everyMinute(); // La tarea se ejecutará cada minuto
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
