<?php

namespace Database\Seeders;

use DateTime;
use App\Models\Vaccination;
use App\Models\Location;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VaccinationsTableSeeder extends Seeder
{

    public function run()
    {
        $vaccination1 = new Vaccination;
        $vaccination1->max_persons = "6";
        $vaccination1->date_time = new DateTime();
        $location1 = Location::all()->first();
        $vaccination1->location()->associate($location1);
        $vaccination1->save();

        $vaccination2 = new Vaccination;
        $vaccination2->max_persons = "12";
        $vaccination2->date_time = new DateTime();
        $location2 = Location::where('id', '2')->first();
        $vaccination2->location()->associate($location2);
        $vaccination2->save();

        $vaccination3 = new Vaccination;
        $vaccination3->max_persons = "15";
        $vaccination3->date_time = new DateTime();
        $location3 = Location::where('id', '3')->first();
        $vaccination3->location()->associate($location3);
        $vaccination3->save();

        $vaccination4 = new Vaccination;
        $vaccination4->max_persons = "1";
        $vaccination4->date_time = new DateTime();
        $location4 = Location::where('id', '4')->first();
        $vaccination4->location()->associate($location4);
        $vaccination4->save();

    }
}
