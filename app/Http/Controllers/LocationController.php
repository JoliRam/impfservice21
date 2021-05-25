<?php

namespace App\Http\Controllers;


use App\Models\Location;
use App\Models\Vaccination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function findByID(int $id):Location {
        $location = Location::where('id', $id)->with(['vaccinations'])->first();
        return $location;
    }

    public function delete(int $id) : JsonResponse
    {
        $location = Location::where('id', $id)->first();
        if ($location != null) {
            $location->delete();
        }
        else
            throw new \Exception("Location couldn't be deleted - it does not exist");
        return response()->json('Location (' . $id . ') successfully deleted', 200);
    }

    public function save(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $location = Location::create($request->all());
            // save vaccinations from location
            if (isset($request['vaccinations']) && is_array($request['vaccinations'])) {
                foreach ($request['vaccinations'] as $vacc) {
                    $vaccination =
                        Vaccination::firstOrNew(['max_participants' => $vacc['max_participants'], 'date' => $vacc['date'],
                            'time' => $vacc['time']]);
                    $location->vaccinations()->save($vaccination);
                }
            }
            DB::commit();
            // return a vaild http response
            return response()->json($location, 201);
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("saving vaccination failed: " . $e->getMessage(), 420);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $location = Location::with(['vaccinations'])
                ->where('id', $id)->first();
            if ($location != null) {
                $location->update($request->all());
            }
            DB::commit();
            $loc1 = Location::with(['vaccinations'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($loc1, 201);
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating location failed: " . $e->getMessage(), 420);
        }
    }

    private function parseRequest(Request $request) : Request {
        $date = new \DateTime($request->published);
        $request['published'] = $date;
        return $request;
    }
}
