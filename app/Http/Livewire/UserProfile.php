<?php

namespace App\Http\Livewire;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UserProfile extends Component
{
    use WithFileUploads;

    public User $user;
    public $showSuccesNotification = false;
    public $showDemoNotification = false;
    public $profile_image;
    
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
        'profile_image' => 'nullable|image|max:1024',
        'user.credits' => 'nullable|integer'
    ];

    public function mount() { 
        $this->user = auth()->user();
    }

    public function save() {
        $this->validate();
    
        try {
            // Vérifiez si une nouvelle image de profil a été téléchargée
            if ($this->profile_image) {
                // Supprimez l'ancienne image de profil si elle existe
                if ($this->user->profile_image) {
                    Storage::disk('public')->delete($this->user->profile_image);
                }
                // Stockez la nouvelle image de profil
                $this->user->profile_image = $this->profile_image->store('profile-images', 'public');
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
        return view('livewire.user-profile');
    }
}
