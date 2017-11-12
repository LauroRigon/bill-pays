<?php

namespace App\Domains\Users\Http;

use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateUser;
use App\Http\Requests\User\DeleteUser;
use App\Domains\Users\User;
use App\Domains\Users\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct(UserRepository $repository)
    {
        $this->userRep = $repository;
    }

    /**
     * Return a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRep->all();

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $this->userRep->create($request->input());

        return response()->json(null, 200);
    }

    /**
     * Return user data to edit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
    {
        $this->userRep->update($request->input(), $user->id);

        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteUser $request, User $user)
    {
        $this->userRep->delete($user->id);

        return response()->json(null, 200);
    }

    /**
     * Remove many resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(DeleteUser $request)
    {
        $this->userRep->deleteMany($request->all());

        return response()->json(null, 200);
    }
}
