<?php

namespace App\Observers;

use App\Http\Resources\api\v1\student\Student;
use App\Models\Package;
use App\Models\SessionClass;
use App\Models\User;

class SetBackageObserver
{
    /**
     * Handle the SessionClass "created" event.
     */
    public function created(SessionClass $sessionClass): void
    {
        //
        $package_id = $sessionClass->package_id ?? Null; // Set New Package
        if ($package_id != Null) { // If Session Not Null
            $student = User::find($sessionClass->student_id); // Get Student
            $package = Package::find($package_id); // Get Package
            $student->sessionsLimite = $package->sessionCount; // Set SessionCount from package to student SessionLimit
            $student->package_id = $package_id; // Set Package For Student
        }

    }

    /**
     * Handle the SessionClass "updated" event.
     */
    public function updated(SessionClass $sessionClass): void
    {
        //
    }

    /**
     * Handle the SessionClass "deleted" event.
     */
    public function deleted(SessionClass $sessionClass): void
    {
        //
    }

    /**
     * Handle the SessionClass "restored" event.
     */
    public function restored(SessionClass $sessionClass): void
    {
        //
    }

    /**
     * Handle the SessionClass "force deleted" event.
     */
    public function forceDeleted(SessionClass $sessionClass): void
    {
        //
    }
}
