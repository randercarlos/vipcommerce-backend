<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserFormRequest;
use App\Models\User;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json($this->userService->findAll($request));
    }

    public function show(string $uuid)
    {
        return response()->json($this->userService->find($uuid));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        return response()->json($this->userService->save($request), 201);
    }

    public function update(UserFormRequest $request, User $user)
    {
        return response()->json($this->userService->save($request, $user), 200);
    }

    public function destroy(string $uuid)
    {
        return response()->json($this->userService->delete($uuid), 200);
    }

}
