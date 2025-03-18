<?php

namespace App;

use App\Models\SessionClass;
use Carbon\Carbon;

class CancelSession
{
    /**
     * Create a new class instance.
     */
    public function __invoke()
    {
        // Make Cancell any Old Session
        $oldSessions = SessionClass::whereDate('date', '<', Carbon::today())->whereNull('end')
            ->update(
                [
                    'status' => 'cancelled',
                    'date' => Carbon::today(),
                ]
            );
        logger()->info("Update All Session Cancelled [$oldSessions]");
        
    }
}
