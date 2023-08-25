<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use PHPUnit\TestRunner\TestResult\Collector;

#[Title('Užduotis: Kontaktų forma')]
class ContactForm extends Component
{
    use WithFileUploads, WithPagination;

    // Define contact form inputs
    public $name;
    public $surname;
    public $phone;
    public $address;
    public $profile_photo;
    public $role;
    public $note;

    public $filterSuperUser;
    public $filterNotSuperUser;

    public $search = '';

    public $editUser = false;

    public function getData()
    {
        return User::where('role', 'LIKE', "%" . $this->filterSuperUser . "%")->paginate(5);
    }

    public function save(User $user)
    {
        // Validate inputs
        $this->validate(
            [
                'name' => 'required|min:3|max:40',
                'surname' => 'required|min:3|max:40',
                'phone' => 'required',
                'address' => 'required|min:3|max:255',
                // 'profile_photo' => 'image|max:2048|mimes:jpeg,png,jpg',
                'role' => 'required',
                'note' => 'required',
            ],
            [
                'name.required' => 'Vardas yra būtinas',
                'surname.required' => 'Pavardė yra būtina',
                'phone.required' => 'Telefono numeris yra būtinas',
                'address.required' => 'Adresas yra būtinas',
                'role.required' => 'Rolė yra būtina',
                'note.required' => 'Pastaba yra būtina',
            ]
        );

        // Create data and insert into database
        $user = new User();
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->phone = $this->phone;
        $user->address = $this->address;

        if ($this->profile_photo) {
            $this->validate([
                'profile_photo' => 'image|max:2048|mimes:jpeg,png,jpg',
            ]);
            $user->profile_photo = $this->profile_photo->store('photos', 'public');
        }
        
        $user->role = $this->role;
        $user->note = $this->note;
        $user->save();

        session()->flash('success','Visi jūsų duomenys išsaugoti sėkmingai.');

        $this->reset();
    }

    public function edit(User $user)
    {
        $this->editUser = $user;
        $this->name = $user->name;
        $this->surname = $user->surname;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->role = $user->role;
        $this->note = $user->note;
    }

    public function cancelEdit()
    {
        $this->editUser = false;
        $this->reset();
    }

    public function update()
    {
        // Validate inputs
        $this->validate(
            [
                'name' => 'required|min:3|max:40',
                'surname' => 'required|min:3|max:40',
                'phone' => 'required',
                'address' => 'required|min:3|max:255',
                // 'profile_photo' => 'image|max:2048|mimes:jpeg,png,jpg',
                'role' => 'required',
                'note' => 'required',
            ],
            [
                'name.required' => 'Vardas yra būtinas',
                'surname.required' => 'Pavardė yra būtina',
                'phone.required' => 'Telefono numeris yra būtinas',
                'address.required' => 'Adresas yra būtinas',
                'role.required' => 'Rolė yra būtina',
                'note.required' => 'Pastaba yra būtina',
            ]
        );

        if ($this->editUser) {
            $user = User::findOrFail($this->editUser->id);
            $user->name = $this->name;
            $user->surname = $this->surname;
            $user->phone = $this->phone;
            $user->address = $this->address;

            if ($this->profile_photo) {
                $this->validate([
                    'profile_photo' => 'image|max:2048|mimes:jpeg,png,jpg',
                ]);
                $user->profile_photo = $this->profile_photo->store('photos', 'public');
            }

            $user->role = $this->role;
            $user->note = $this->note;
            $user->save();

            $this->cancelEdit();

            session()->flash('success', 'Vartotojo duomenys atnaujinti sėkmingai.');
            $this->reset();
        }
    }

    public function delete(User $user)
    {
        $user->delete();

        session()->flash('delete', 'Vartotojo duomenys ištrinti sėkmingai.');
    }

    // public function filterUsers()
    // {
    //     $query = User::query();
    //     if ($this->filterSuperUser) {
    //         $query->where('role', 'Administratorius');
    //     }

    //     if ($this->filterNotSuperUser) {
    //         $query->where('role', '<>', 'Administratorius');
    //     }

    //     if ($this->search) {
    //         $query->where('name', 'like', '%' . $this->search . '%');
    //     }

    //     return $query->orderBy('created_at', 'DESC')->paginate(5);

    //     $this->resetPage();
    // }

    public function render()
    {

        // $users = User::paginate(5);

        // return view('livewire.contact-form', ['users' => $users]);


        return view('livewire.contact-form', [
            'users' => User::where('name', 'like', '%' . $this->search .'%')->orderBy('created_at', 'DESC')->paginate(5)
        ]);
    }

}