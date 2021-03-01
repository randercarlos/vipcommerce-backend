<?php

namespace App\Services;

use App\Models\Location;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class UserService extends AbstractService
{
    protected $model;

    public function __construct() {
        $this->model = new User();
    }

    public function findAll(Request $request) {

        $query = User::with(['person','location', 'picture'])
            ->whereHas('person', function($query) use ($request) {
                if ($request->query('name')) {
                    $query->where(function($q) use ($request) {
                        $q->where('people.title', 'like', '%' . strtolower($request->query('name')) . '%');
                        $q->orWhere('people.first_name', 'like', '%' . strtolower($request->query('name')) . '%');
                        $q->orWhere('people.last_name', 'like', '%' . strtolower($request->query('name')) . '%');
                    });
                }

                if ($request->query('gender')) {
                    $query->where('people.gender', $request->query('gender'));
                }

                if ($request->query('nat')) {
                    $query->where('people.nat', $request->query('nat'));
                }
            })
            ->latest()
            ->paginate($request->_limit ?? User::RECORDS_PER_PAGE, ['*'], 'page', $request->_page ?? 1);

        return $query;
    }

    public function find(string $uuid): Model {
        if (!$user = User::with(['person','location', 'picture'])->find($uuid)) {
            throw new ModelNotFoundException("Person with uuid $uuid not found!" );
        }

        return $user;
    }


    public function save(Request $request, Model $user = null): Model {
        //dd($request->all());

        $person = null;
        $location = null;
        if ($user) {
            $person = $user->person;
            $location = $user->location;
        } else {
            $user = new User();
            $person = new Person();
            $location = new Location();
        }

        $names = explode(' ', $request->input('name'));
        if (count($names) === 1) {
            $person->first_name = $request->input('name');
        } elseif (count($names) > 1) {
            $person->first_name = $names[0];
            array_shift($names);
            $person->last_name = implode(' ', $names);
        }
        $person->email = $request->input('email');
        $person->gender = $request->input('gender');
        $person->birthday = $request->input('birthday');
        $person->id_value = $request->input('id_value');
        $person->phone = $request->input('phone');
        $person->nat = $request->input('nat');
        if (!$person->save()) {
            throw new \Exception("Falha ao atualizar dados");
        }

        $location->street = $request->input('street');
        $location->number = $request->input('number');
        $location->city = $request->input('city');
        $location->state = $request->input('state');
        $location->country = $request->input('country');
        $location->postcode = $request->input('postcode');
        if (!$location->save()) {
            throw new \Exception("Falha ao atualizar dados");
        }

        return $user;
    }

}
