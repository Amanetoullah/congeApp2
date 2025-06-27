<div class="card-body">
                         <form wire:submit.prevent="store"
                              method="POST" class="mt-3">

                              <div class="form-group mb-3">
                                <label for="registration_number">Numéro d’enregistrement </label>
                                <input type="text" class="form-control"
                                name="registration_number" placeholder="Numéro d’enregistrement"
                                wire:model="registration_number">
                                @error('registration_number') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">Nom Complet</label>
                                <input type="text" class="form-control"
                                name="name" placeholder="Nom Complet"
                                wire:model="name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mt-2">
                                <label for="" class="form-label">Image</label>
                                <input type="file" class="form-control mb-3 p-2 border" wire:model="image" id="">
                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}" alt="" width="100px" height="100px">
                                @endif
                                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control"
                                name="email" placeholder="Email"
                                wire:model="email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control"
                                name="password" placeholder="Password"
                                wire:model="password">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="departement">Departement</label>
                                <select class="form-control" wire:model="departement">
                                    <option value=""> Sélectionner un département </option>
                                    @foreach ($departements as $departement)
                                        <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                    @endforeach
                                </select>
                                @error('departement') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="hire_date">Date Embauche</label>
                                <input type="date" class="form-control"
                                name="hire_date" placeholder="Date Embauche"
                                wire:model="hire_date">
                                @error('hire_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone">telephone</label>
                                <input type="tel" class="form-control"
                                name="phone" placeholder="telephone"
                                wire:model="phone">
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="address">Adresse</label>
                                <input type="text" class="form-control"
                                name="address" placeholder="Adresse"
                                wire:model="address">
                                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="city">Ville</label>
                                <input type="text" class="form-control"
                                name="city" placeholder="Ville"
                                wire:model="city">
                                @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">

                                <button type="submit" class="btn btn-primary">
                                    <span wire:loading wire:target="store" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Enregistrer
                                </button>
                            </div>






                        </form>
                    </div>
