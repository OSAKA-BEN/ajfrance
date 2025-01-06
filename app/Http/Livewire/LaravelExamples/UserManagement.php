<?php

namespace App\Http\Livewire\LaravelExamples;

use Livewire\Component;
use App\Models\User;

class UserManagement extends Component
{
    public function render()
    {
        return view('livewire.laravel-examples.user-management', [
            'users' => User::all()
        ]);
    }

    public function updateUserRole($userId, $newRole)
    {
        $currentUser = auth()->user();
        
        // Vérification que seul l'admin peut modifier les rôles
        if ($currentUser->role !== 'admin') {
            abort(403, 'Non autorisé');
        }

        // Empêcher l'admin de modifier son propre rôle
        if ($currentUser->id === $userId) {
            abort(403, 'Vous ne pouvez pas modifier votre propre rôle');
        }

        $user = User::findOrFail($userId);
        $user->update(['role' => $newRole]);
    }
}
