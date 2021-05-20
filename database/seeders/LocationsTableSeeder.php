<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;


class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $location1 = new Location;
            $location1->plz = "4020";
            $location1->city = "Linz";
            $location1->street = "Europaplatz";
            $location1->street_number = "4";
            $location1->loc_desc = "Designcenter";
            $location1->save();

        $location2 = new Location;
        $location2->plz = "4181";
        $location2->city = "Oberneukirchen";
        $location2->street = "Lobenstein";
        $location2->street_number = "62";
        $location2->loc_desc = "Neue Mittelschule";
        $location2->save();

        $location3 = new Location;
        $location3->plz = "4111";
        $location3->city = "Walding";
        $location3->street = "Sportstraße";
        $location3->street_number = "10";
        $location3->loc_desc = "Sportzentrum";
        $location3->save();

        $location4 = new Location;
        $location4->plz = "4193";
        $location4->city = "Reichenthal";
        $location4->street = "Ringstraße";
        $location4->street_number = "6";
        $location4->loc_desc = "Praxis Dr. Winkler";
        $location4->save();
    }
}
