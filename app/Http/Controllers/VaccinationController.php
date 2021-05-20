<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;
use App\Models\Vaccination;
use phpDocumentor\Reflection\Types\Integer;

class VaccinationController extends Controller
{

    public function index(){
        $vaccinations = Vaccination::with(['location', 'users'])->get();
        return $vaccinations;
    }

    public function findByID(int $id):Vaccination {
        $vaccination = Vaccination::where('id', $id)->with(['location', 'users'])->first();
        return $vaccination;
    }

    public function delete(int $id) : JsonResponse
    {
        $vaccination = Vaccination::where('id', $id)->first();
        if ($vaccination != null) {
            $vaccination->delete();
        }
        else
            throw new \Exception("Vaccination couldn't be deleted - it does not exist");
        return response()->json('Vaccination (' . $id . ') successfully deleted', 200);
    }

    public function show($vaccination){
        $vaccination = Vaccination::find($vaccination);
        return view('vaccinations.show',compact('vaccination'));
    }


public function save(Request $request) : JsonResponse {
    $request = $this->parseRequest($request);

    DB::beginTransaction();
    try {
        $vaccination = Vaccination::create($request->all());
        if(isset($request['users']) && is_array($request['users'])){
            foreach ($request['users'] as $u) {
                $user = User::firstOrNew(['name'=>$u['name'], 'gender'=>$u['gender'], 'birthday'=>$u['birthday'], 'svnr'=>$u['svnr'], 'phonenumber'=>$u['phonenumber'], 'is_vaccinated'=>$u['is_vaccinated'], 'email'=>$u['email'], 'password'=>$u['password']]);
                $vaccination->users()->save($user);
            }
        }

        DB::commit();
        return response()->json($vaccination, 201);
    }
    catch (\Exception $e) {
        DB::rollBack();
        return response()->json("Saving Vaccination has failed: " . $e->getMessage(), 420);
    }
}

private function parseRequest(Request $request) : Request {
    $date = new \DateTime($request->published);
    $request['published'] = $date;
    return $request;
}

    public function update(Request $request, int $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $vaccination = Vaccination::with(['location', 'users'])->where('id', $id)->first();
            if ($vaccination != null) {
                $request = $this->parseRequest($request);
                $vaccination->update($request->all());
                $vaccination->users()->delete();
                // save users
                if (isset($request['users']) && is_array($request['users'])) {
                    foreach ($request['users'] as $u) {
                        $user = User::firstOrNew(['name'=>$u['name'], 'gender'=>$u['gender'], 'birthday'=>$u['birthday'], 'svnr'=>$u['svnr'], 'phonenumber'=>$u['phonenumber'], 'is_vaccinated'=>$u['is_vaccinated'], 'email'=>$u['email'], 'password'=>$u['password']]);
                        $vaccination->users()->save($user);
                    }
                }
            }
            DB::commit();
            $vaccinations1 = Vaccination::with(['location', 'users'])
                ->where('id', $id)->first();
            return response()->json($vaccinations1, 201);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json("Updating Vaccination failed: " . $e->getMessage(), 420);
        }
    }





}
