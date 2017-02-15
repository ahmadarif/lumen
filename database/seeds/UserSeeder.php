<?php

use App\Http\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Ahmad Arif";
        $user->email = "arif@mail.com";
        $user->password = Hash::make("arif");
        $user->save();
    }
}
