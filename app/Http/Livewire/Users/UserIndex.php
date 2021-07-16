<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public $search = "";
    public $username, $firstName, $lastName, $email, $password;
    public $userId;
    public $editMode = false;

    protected $rules = [
        'username' => 'required',
        'firstName' => 'required',
        'lastName' => 'required',
        'password' => 'required',
        'email' => 'required',
    ];

    public function storeUser()
    {
        $this->validate();
        User::create([
            'username' => $this->username,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);  
        
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#userModal', 'actionModal' => 'hide'] );

        session()->flash('user-message', 'User created succesfully');

    }

    public function render()
    {
        $users = User::all();
        if(strlen($this->search)> 2 ){
            $users = User::where('username', 'like', "%{$this->search}%")->get();
        }
        return view('livewire.users.user-index', ['users' => $users])->layout('layouts.main');
    }

    public function showEditModal($id)
    {
        $this->reset();
        $this->editMode = true;
        $this->userId = $id;
        $this->loadUser();
        $this->dispatchBrowserEvent('modal',['modalId' => '#userModal', 'actionModal' => 'show'] );


    }

    public function loadUser()
    {
        $user =User::find($this->userId);
        $this->username = $user->username; 
        $this->firstName = $user->first_name; 
        $this->lastName = $user->last_name; 
        $this->email = $user->email; 
        $this->address = $user->address; 
    }

    public function updateUser()
    {
        $validated = $this->validate([
            'username' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
        ]);
        $user =User::find($this->userId);
        $user->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#userModal', 'actionModal' => 'hide'] );

        session()->flash('user-message', 'User updated succesfully');

    }

    public function showUserModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#userModal', 'actionModal' => 'show'] );

    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('modal',['modalId' => '#userModal', 'actionModal' => 'hide'] );
        $this->reset();
    }

    public function deleteUser($id)
    {
        $user =User::find($id);
        $user->delete();

        session()->flash('user-message', 'User deleted succesfully');
    }
}
