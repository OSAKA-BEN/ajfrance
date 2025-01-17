<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class NewUser extends Component
{
    use WithFileUploads;

    // Form fields
    public $currentStep = 1;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $phone;
    public $country;
    public $address;
    public $city;
    public $state;
    public $zipcode;
    public $profile_image;

    // Notifications
    public $showSuccessNotification = false;
    public $showErrorNotification = false;
    public $errorMessage = '';

    // Validation rules per step
    protected $validationAttributes = [
        'name' => 'Name',
        'email' => 'Email Address',
        'password' => 'Password',
        'password_confirmation' => 'Password Confirmation',
        'phone' => 'Phone Number',
        'country' => 'Country',
        'address' => 'Address',
        'city' => 'City',
        'state' => 'State',
        'zipcode' => 'Zipcode',
        'profile_image' => 'Profile Image'
    ];

    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'phone' => 'nullable',
            'country' => 'nullable',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'zipcode' => 'nullable',
            'profile_image' => 'nullable|image|max:1024'
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 3 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already used.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'password_confirmation.required' => 'Password Confirmation is required.',
            'password_confirmation.min' => 'Password Confirmation must be at least 6 characters.',
            'password_confirmation.confirmed' => 'Passwords do not match.',
            'profile_image.image' => 'The file must be an image.',
            'profile_image.max' => 'The image must not exceed 1024 Ko.',
        ];
    }

    public function nextStep()
    {
        if ($this->currentStep === 1) {
            $this->validateUserInfo();
        } elseif ($this->currentStep === 2) {
            $this->validateAddress();
        }

        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    protected function validateUserInfo()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable'
        ]);
    }

    protected function validateAddress()
    {
        $this->validate([
            'country' => 'nullable',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'zipcode' => 'nullable'
        ]);
    }

    public function save()
    {
        try {
            // Final validation
            $this->validate();

            $userData = [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'phone' => $this->phone,
                'country' => $this->country,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'zipcode' => $this->zipcode,
                'role' => 'guest',
                'credits' => 2
            ];

            if ($this->profile_image) {
                $userData['profile_image'] = $this->profile_image->store('profile-images', 'public');
            }

            User::create($userData);

            $this->showSuccessNotification = true;
            $this->showErrorNotification = false;
            $this->reset(['name', 'email', 'password', 'password_confirmation', 'phone', 'country', 'address', 'city', 'state', 'zipcode', 'profile_image']);

        } catch (\Exception $e) {
            $this->showSuccessNotification = false;
            $this->showErrorNotification = true;
            $this->errorMessage = "Error: " . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.new-user');
    }
} 