<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class UpdateEventStatuses extends Command
{
    /**
     * php artisan events:update-status
     */
    protected $signature = 'events:update-status';

    protected $description = "Passe automatiquement en 'completed' les événements dont la date est dépassée";

    public function handle(): int
    {
        $events = Event::needingStatusUpdate()->get();

        foreach ($events as $event) {
            $event->update(['status' => 'completed']);
            $this->info("Événement #{$event->id} ({$event->name}) marqué comme terminé.");
        }

        if ($events->isEmpty()) {
            $this->info('Aucun événement à mettre à jour.');
        }

        return self::SUCCESS;
    }
}
