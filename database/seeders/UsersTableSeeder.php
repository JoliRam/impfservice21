<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vaccination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = "Johanna Rammerstorfer";
        $user->gender = "weiblich";
        $user->birthday = "30.07.1998";
        $user->svnr = "3007984800";
        $user->phonenumber = "06502006848";
        $user->is_vaccinated = true;
        $user->email = "johanna.rammerstorfer@gmx.net";
        $user->password = bcrypt("secret");
        $user->is_admin = true;
        $user->save();

        $user2 = new User;
        $user2->name = "Jakob Poscher";
        $user2->gender = "männlich";
        $user2->birthday = "15.06.1996";
        $user2->svnr = "1506961234";
        $user2->phonenumber = "16";
        $user2->is_vaccinated = false;
        $user2->email = "jakob.poscher@gmx.at";
        $user2->password = bcrypt("secret2");
        $user2->is_admin = false;
        $user2->save();

        $user3 = new User;
        $user3->name = "Claudia Rammerstorfer";
        $user3->gender = "weiblich";
        $user3->birthday = "06.07.1989";
        $user3->svnr = "1506965800";
        $user3->phonenumber = "45";
        $user3->is_vaccinated = false;
        $user3->email = "claudia.rammerstorfer@gmx.at";
        $user3->password = bcrypt("secret3");
        $user3->is_admin = false;

        $vaccination3 = Vaccination::all()->last();
        $user3->vaccination()->associate($vaccination3);
        $user3->save();
    }
}
