<?php

namespace App\Events;

use App\Contracts\Storeable;
use App\HasDefaultGetter;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class StoreableUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
	use HasDefaultGetter;


    /**
     * Criar uma nova instância de evento.
     */
    public function __construct(protected Storeable $storeable)
    {
        //
    }
}
