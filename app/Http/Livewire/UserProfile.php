<?php

namespace App\Http\Livewire;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserProfile extends Component
{
    use WithFileUploads;

    public User $user;
    public $showSuccesNotification = false;
    public $showDemoNotification = false;
    public $profileImage;
    
    protected $rules = [
        'user.name' => 'max:40|min:3',
        'user.email' => 'email:rfc,dns',
        'user.phone' => 'max:10',
        'user.about' => 'max:200',
        'user.country' => 'nullable|string',
        'user.address' => 'nullable|string',
        'user.city' => 'nullable|string',
        'user.state' => 'nullable|string',
        'user.zipcode' => 'nullable|string',
        'profileImage' => 'nullable|image|max:1024',
        'user.credits' => 'nullable|integer'
    ];

    public function mount() { 
        $this->user = auth()->user();
    }

    public function save() {
        if(env('IS_DEMO')) {
            $this->showDemoNotification = true;
        } else {
            $this->validate();
            
            if ($this->profileImage) {
                $imagePath = $this->profileImage->store('profile-images', 'public');
                $this->user->profile_image = $imagePath;
            }
            
            $this->user->save();
            $this->showSuccesNotification = true;
        }
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
