<?php

namespace App\Http\Controllers;


use App\Models\Location;
use App\Models\Vaccination;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(){
        $locations = Location::with(['vaccinations'])->get();
        return $locations;
    }

    public function show($location){
        $location = Location::find($location);
        return view('locations.show',compact('location'));
    }

    public function save(Request $request) : JsonResponse {
        $request = $this->parseRequest($request);

        DB::beginTransaction();
        try {
            $location = Location::create($request->all());
            if (isset($request['vaccinations']) && is_array($request['vaccinations'])) {
                foreach ($request['vaccinations'] as $vacc) {
                    $vaccination = Vaccination::firstOrNew(['max_persons'=>$vacc['max_persons'],'date_time'=>$vacc['date_time'], 'location_id'=>$vacc['location_id']]);
                    $location->vaccinations()->save($vaccination);
                }
            }

            DB::commit();
            return response()->json($location, 201);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json("Saving Location has failed: " . $e->getMessage(), 420);
        }
    }

    private function parseRequest(Request $request) : Request {
        $date = new \DateTime($request->published);
        $request['published'] = $date;
        return $request;
    }
}
