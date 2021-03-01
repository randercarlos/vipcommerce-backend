<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades;
use App\Models\Person;
use App\Models\User;
use App\Models\Location;
use App\Models\Picture;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $records = json_decode(\File::get(database_path('users.json')))->results;
        if (count($records) > 0) {
            foreach($records as $record) {

                $user = User::create([
                    'uuid' => $record->login->uuid,
                    'username' => $record->login->username,
                    'password' => $record->login->password,
                    'salt' => $record->login->salt,
                    'md5' => $record->login->md5,
                    'sha1' => $record->login->sha1,
                    'sha256' => $record->login->sha256,
                ]);

                Person::create([
                    'id_name' => $record->id->name,
                    'id_value' => $record->id->value,
                    'title' => $record->name->title,
                    'first_name' => $record->name->first,
                    'last_name' => $record->name->last,
                    'email' => $record->email,
                    'gender' => $record->gender,
                    'birthday' => $record->dob->date,
                    'phone' => $record->phone,
                    'cell' => $record->cell,
                    'nat'=> $record->nat,
                    'registered' => $record->registered->date,
                    'user_uuid' => (string) $user->uuid,
               ]);



               Location::create([
                    'street' => $record->location->street->name,
                    'number' => $record->location->street->number,
                    'city' => $record->location->city,
                    'state' => $record->location->state,
                    'country' => $record->location->country,
                    'postcode' => $record->location->postcode,
                    'latitude' => $record->location->coordinates->latitude,
                    'longitude' => $record->location->coordinates->longitude,
                    'timezone_offset' => $record->location->timezone->offset,
                    'timezone_description' => $record->location->timezone->description,
                    'user_uuid' => (string) $user->uuid,
               ]);

               Picture::create([
                    'large' => $record->picture->large,
                    'medium' => $record->picture->medium,
                    'thumbnail' => $record->picture->thumbnail,
                    'user_uuid' => (string) $user->uuid,
               ]);
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
