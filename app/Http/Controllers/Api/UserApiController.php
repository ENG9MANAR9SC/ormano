<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserOptionResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserApiController extends Controller
{
    /**
     * Display a paginated list of users.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $users = User::query()
            ->orderBy('name')
            ->paginate(15);

        return UserOptionResource::collection($users);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \App\Http\Requests\User\StoreUserRequest  $request
     * @return \App\Http\Resources\UserOptionResource
     */
    public function store(StoreUserRequest $request): UserOptionResource
    {
        $user = User::query()->create($request->validated());

        return new UserOptionResource($user);
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \App\Http\Resources\UserOptionResource
     */
    public function show(User $user): UserOptionResource
    {
        return new UserOptionResource($user);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \App\Http\Requests\User\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \App\Http\Resources\UserOptionResource
     */
    public function update(UpdateUserRequest $request, User $user): UserOptionResource
    {
        $user->update($request->validated());

        return new UserOptionResource($user);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
