<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * @return [type]
     */
    public function index()
    {
        return $this->user->get();
    }


    /**
     * @param User $user
     *
     * @return [type]
     */
    public function show($user)
    {
        return $this->user->findOrFail($user);
    }



    /**
     * @param Request $request
     *
     * @return [type]
     */
    public function store(Request $request)
    {
        $validate = $this->validate(
            $request,
            [
                'email' => ['required', 'unique:users'],
                'password' => 'required',
            ],
            [
                'email.unique' => 'Este e-mail já foi utilizado.',
                'email.required' => 'É necessário um e-mail para cadastrar um usuário.',
                'password.required' => 'É necessário uma senha para cadastrar um usuário.'
            ]
        );

        $this->user->fill($request->all());
        $this->user->save();
        return $this->user;
    }


    /**
     * @param User $user
     *
     * @return [type]
     */
    public function update(Request $request, $user)
    {
        $this->user = $this->user->findOrFail($user);

        $this->validate(
            $request,
            [
                'email' => Rule::unique('users')->ignore($this->user->id, 'id')
            ],
            [
                'email.required' => 'É necessário um e-mail para cadastrar um usuário.',
            ]
        );

        $this->user->fill($request->all());
        $this->user->save();

        return $this->user;
    }


    /**
     * @param User $user
     *
     * @return [type]
     */
    public function destroy($user)
    {
        $this->user = $this->user->findOrFail($user);
        $this->user->delete();

        return 'O usuário ' . $this->user->email . ' #' . $this->user->id . ' foi deletado com sucesso!';
    }
}
