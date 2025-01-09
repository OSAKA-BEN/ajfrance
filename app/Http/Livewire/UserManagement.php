<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserManagement extends Component
{
    use WithPagination;

    public $userIdToDelete;
    public $isEditing = false;
    public $editUserId;
    
    // Ajout des propriétés pour les notifications
    public $showSuccessNotification = false;
    public $showErrorNotification = false;
    public $errorMessage = '';
    public $successMessage = '';

    public function render()
    {
        $allUsers = User::all();
        $paginatedUsers = User::simplePaginate(10);

        return view('livewire.users-management', [
            'users' => $paginatedUsers,
            'allUsers' => $allUsers
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

    public function confirmUserDeletion($userId)
    {
        if (auth()->user()->role !== 'admin') {
            return;
        }
        
        $this->userIdToDelete = $userId;
        $this->dispatch('show-delete-modal');
    }

    public function deleteUser()
    {
        if (auth()->user()->role !== 'admin') {
            return;
        }
        
        try {
            $user = User::find($this->userIdToDelete);
            if ($user) {
                $user->delete();
                $this->showSuccessNotification = true;
                $this->successMessage = 'User deleted successfully';
                $this->showErrorNotification = false;
                $this->dispatch('hide-delete-modal');
            }
        } catch (\Exception $e) {
            $this->showErrorNotification = true;
            $this->errorMessage = "Error: " . $e->getMessage();
            $this->showSuccessNotification = false;
        }
    }
}
