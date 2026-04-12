<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('users.index', ['users' => $users]);
    }

    public function create(): View
    {
        return view('users.create', [
            'user' => new User(),
            'roles' => $this->roles(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::query()->create($request->validated());

        return redirect()->route('users.show', $user)
            ->with('success', __('User created successfully.'));
    }

    public function show(User $user): View
    {
        return view('users.show', ['user' => $user]);
    }

    public function edit(User $user): View
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => $this->roles(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()->route('users.show', $user)
            ->with('success', __('User updated successfully.'));
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', __('User deleted successfully.'));
    }

    /**
     * @return array<string>
     */
    private function roles(): array
    {
        return ['Admin', 'User'];
    }
}
