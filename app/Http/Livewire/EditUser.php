<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EditUser extends Component
{
    use WithFileUploads;

    public User $user;
    public $profile_image;
    public $new_password;
    public $showSuccessNotification = false;
    public $showErrorNotification = false;
    public $errorMessage = '';

    protected $rules = [
        'user.name' => 'required|min:3',
        'user.email' => 'required|email',
        'user.phone' => 'nullable|string',
        'user.about' => 'nullable|string',
        'user.address' => 'nullable|string',
        'user.city' => 'nullable|string',
        'user.state' => 'nullable|string',
        'user.zipcode' => 'nullable|string',
        'user.country' => 'nullable|string',
        'user.role' => 'required|in:admin,teacher,student,guest',
        'user.credits' => 'nullable|integer|min:0',
        'profile_image' => 'nullable|image|max:1024',
        'new_password' => 'nullable|min:6'
    ];

    public function mount($userId)
    {
        $this->user = User::findOrFail($userId);
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->profile_image) {
                if ($this->user->profile_image) {
                    Storage::disk('public')->delete($this->user->profile_image);
                }
                $this->user->profile_image = $this->profile_image->store('profile-images', 'public');
            }

            if ($this->new_password) {
                $this->user->password = Hash::make($this->new_password);
            }

            $this->user->save();

            $this->showSuccessNotification = true;
            $this->showErrorNotification = false;
        } catch (\Exception $e) {
            $this->showErrorNotification = true;
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.edit-user');
    }
} 