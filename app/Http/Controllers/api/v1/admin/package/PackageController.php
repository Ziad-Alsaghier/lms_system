<?php

namespace App\Http\Controllers\api\v1\admin\package;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\admin\backage\PackageRequest;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    // This Is About All Controll Package

    public function __construct(
        private User $user,
        private Package $package,
    ){}


    public function index(){
        $packags = $this->package?->get();

        return response()->json([
            'message'=>'success',
            'packages'=>$packags
        ]);
    }

    public function store(PackageRequest $request){
        $nameRequest = $request->validated();
        $package = $this->package->create($nameRequest);

        return response()->json([
            'message'=>'success',
            'package'=>$package
        ]);
    }

            public function update(PackageRequest $request,Package $package){
                    $nameRequest = $request->validated();
                try {
                    $updated = $package->update($nameRequest);
                } catch (\Throwable $th) {
                    throw $th;
                }
        return response()->json([
            'message'=>'success',
            'package'=>$package
        ]);
            }


            public function destroy(Package $package){
                $deleted = $package->delete();
                if($deleted){
            return response()->json([
                    'message'=>'success',
                    'package'=>'Package Deleted Successfully'
            ]);
                } 
            }
            
}
