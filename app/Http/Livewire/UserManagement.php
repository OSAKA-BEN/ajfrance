<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class UserManagement extends Component
{
    public $userIdToDelete;
    public $isEditing = false;
    public $editUserId;
    
    public function render()
    {
        return view('livewire.users-management', [
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

    public function updateUserCredits($userId, $credits)
    {
        $currentUser = auth()->user();
        
        if ($currentUser->role !== 'admin') {
            abort(403, 'Non autorisé');
        }

        $user = User::findOrFail($userId);
        
        if (!$user->canHaveCredits()) {
            abort(403, 'Cet utilisateur ne peut pas avoir de crédits');
        }

        $user->update(['credits' => max(0, (int)$credits)]);
    }
    
    public function confirmDelete($userId)
    {
        $this->userIdToDelete = $userId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }
    
    public function deleteUser()
    {
        if (auth()->user()->role !== 'admin') {
            return;
        }
        
        $user = User::find($this->userIdToDelete);
        if ($user) {
            $user->delete();
            session()->flash('message', 'Utilisateur supprimé avec succès.');
        }
        
        $this->dispatchBrowserEvent('hide-delete-modal');
    }
    
    public function edit($userId)
    {
        if (auth()->user()->role !== 'admin') {
            return;
        }
        
        $this->editUserId = $userId;
        $this->isEditing = true;
        // Rediriger vers la page d'édition ou charger les données dans un formulaire modal
        return redirect()->route('user.edit', $userId);
    }
}
