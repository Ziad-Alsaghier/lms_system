<?php
namespace App\services;

use App\Models\Package as UserPackage;
trait Package
{
    //
    // This Is All Services about Package
    public function checkActivation( $package_id){
        $package = UserPackage::where("id", $package_id)->first();
        if ($package->status == 'active') {
                $package->active = true;
            return $package;
        }else{
                $package->active = false;
            return $package;
        }
    }
}
