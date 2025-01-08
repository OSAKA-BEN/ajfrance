<div>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4">
          <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
              <div class="card">
                <div class="card-body p-3">
                  <div class="row">
                    <div class="col-8">
                      <div class="numbers">
                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Guests</p>
                        <h5 class="font-weight-bolder mb-0">
                          {{ $users->where('role', 'guest')->count() }}
                        </h5>
                      </div>
                    </div>
                    <div class="col-4 text-end">
                      <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md">
                      <i class="bi bi-person-add text-lg opacity-10"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
              <div class="card">
                <div class="card-body p-3">
                  <div class="row">
                    <div class="col-8">
                      <div class="numbers">
                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Students</p>
                        <h5 class="font-weight-bolder mb-0">
                          {{ $users->where('role', 'student')->count() }}
                        </h5>
                      </div>
                    </div>
                    <div class="col-4 text-end">
                      <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md">
                      <i class="bi bi-people text-lg opacity-10"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
              <div class="card">
                <div class="card-body p-3">
                  <div class="row">
                    <div class="col-8">
                      <div class="numbers">
                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Teachers</p>
                        <h5 class="font-weight-bolder mb-0">
                          {{ $users->where('role', 'teacher')->count() }}
                        </h5>
                      </div>
                    </div>
                    <div class="col-4 text-end">
                      <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md">
                      <i class="bi bi-person-video3 text-lg opacity-10"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6">
              <div class="card">
                <div class="card-body p-3">
                  <div class="row">
                    <div class="col-8">
                      <div class="numbers">
                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Admins</p>
                        <h5 class="font-weight-bolder mb-0">
                          {{ $users->where('role', 'admin')->count() }}
                        </h5>
                      </div>
                    </div>
                    <div class="col-4 text-end">
                      <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md">
                      <i class="bi bi-person-fill-lock text-lg opacity-10"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Users</h5>
                            </div>
                            <a href="#" class="btn bg-gradient-info text-white btn-sm mb-0" type="button">+&nbsp; New User</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Photo
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            role
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Creation Date
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Credits
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->id }}</p>
                                        </td>
                                        <td>
                                            <div>
                                                <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                                        </td>
                                        <td class="text-center text-xs">
                                            @if(auth()->user()->role === 'admin' && auth()->user()->id !== $user->id)
                                                <select wire:change="updateUserRole({{ $user->id }}, $event.target.value)" class="form-control-sm">
                                                    <option value="guest" @if($user->role === 'guest') selected @endif>Guest</option>
                                                    <option value="student" @if($user->role === 'student') selected @endif>Student</option>
                                                    <option value="teacher" @if($user->role === 'teacher') selected @endif>Teacher</option>
                                                    <option value="admin" @if($user->role === 'admin') selected @endif>Admin</option>
                                                </select>
                                            @else
                                                <span>{{ $user->role }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $user->created_at->format('d/m/y') }}</span>
                                        </td>
                                        <td class="text-center text-xs">
                                            @if(auth()->user()->role === 'admin' && $user->canHaveCredits())
                                                <input 
                                                    type="number" 
                                                    min="0" 
                                                    value="{{ $user->credits }}"
                                                    wire:change="updateUserCredits({{ $user->id }}, $event.target.value)"
                                                    class="form-control form-control-sm"
                                                    style="width: 80px; margin: 0 auto;"
                                                >
                                            @else
                                                <span>{{ $user->canHaveCredits() ? $user->credits : '-' }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if(auth()->user()->role === 'admin')
                                                <button wire:click="edit({{ $user->id }})" class="btn btn-sm btn-secondary m-0">
                                                    Éditer
                                                </button>
                                                
                                                <button wire:click="confirmDelete({{ $user->id }})" class="btn btn-sm btn-danger m-0 p-2">
                                                  <i class="bi bi-trash fs-6 text-white"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </main>

      <!-- Modal de confirmation de suppression -->
      <div class="modal fade" id="deleteModal" tabindex="-1" wire:ignore.self>
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Confirmer la suppression</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                      <button type="button" class="btn btn-danger" wire:click="deleteUser">Confirmer</button>
                  </div>
              </div>
          </div>
      </div>
  </div>

