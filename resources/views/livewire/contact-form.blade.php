<div>
    <div class="text-center py-10">

        <h1 class="text-3xl font-semibold bg-black text-white p-2 my-4 max-w-[500px] mx-auto rounded-md">Kontaktų Forma</h1>

        <form wire:submit.prevent='save' class=" max-w-[500px] mx-auto py-4 space-y-4 border-2 border-black">
            @csrf
            <div class="flex flex-col justify-center items-center">
                <label class="text-xl font-bold" for="name">Vardas:</label>
                <input wire:model='name' class="border-2 border-black rounded-md p-1 w-[300px] @error('name') is-invalid @enderror" type="text" name="name" placeholder="Įveskite savo vardą">
                {{-- Error --}}
                @error('name')
                    <span class="text-red-600 mt-2">{{ $message }}</span>
                @enderror
            </div>
    
            <div class="flex flex-col justify-center items-center">
                <label class="text-xl font-bold" for="surname">Pavardė:</label>
                <input wire:model='surname' class="border-2 border-black rounded-md p-1 w-[300px] @error('surname') is-invalid @enderror" type="text" name="surname" placeholder="Įveskite savo pavardę">
                {{-- Error --}}
                @error('surname')
                    <span class="text-red-600 mt-2">{{ $message }}</span>
                @enderror
            </div>
    
            <div class="flex flex-col justify-center items-center">
                <label class="text-xl font-bold" for="phone">Telefonas:</label>
                <input wire:model='phone' class="border-2 border-black rounded-md p-1 w-[300px] @error('phone') is-invalid @enderror" type="tel" name="phone" pattern="(\+370|)[6-9]\d{7}" title="Įveskite galiojantį tel numerį, pvz: +37063333333" placeholder="Įveskite savo telefono numerį">
                {{-- Error --}}
                @error('phone')
                    <span class="text-red-600 mt-2">{{ $message }}</span>
                @enderror
            </div>
    
            <div class="flex flex-col justify-center items-center">
                <label class="text-xl font-bold" for="address">Adresas:</label>
                <input wire:model='address' class="border-2 border-black rounded-md p-1 w-[300px] @error('address') is-invalid @enderror" type="text" name="address" placeholder="Įveskite savo telefono numerį">
                {{-- Error --}}
                @error('address')
                    <span class="text-red-600 mt-2">{{ $message }}</span>
                @enderror
            </div>
    
            <div class="flex flex-col justify-center items-center">
                <label class="text-xl font-bold" for="profile_photo">Nuotrauka:</label>
                <input wire:model='profile_photo' class="bg-slate-500 text-white rounded-md" type="file" name="profile_photo">
                {{-- Photo preview --}}
                @if ($profile_photo)
                    <span class="text-indigo-600 font-bold text-lg">Failo peržiūra:</span>
                    <img src="{{ $profile_photo->temporaryUrl() }}" alt="photo">
                @endif
            </div>
    
            <div class="flex flex-col justify-center items-center">
                <label class="text-xl font-bold" for="roles">Pasirinkite rolę:</label>
                <select wire:model='role' class="border-2 border-black rounded-sm @error('role') is-invalid @enderror" name="role">
                    <option value="Svečias" selected>Svečias</option>
                    <option value="Klientas">Klientas</option>
                    <option value="Administratorius">Admin (super user)</option>
                    <option value="Programuotojas">Programuotojas (super user)</option>
                </select>
                @error('role')
                    <span class="text-red-600 mt-2">{{ $message }}</span>
                @enderror 
            </div>

            <div class="flex flex-col justify-center items-center">
                <label class="text-xl font-bold" for="notes">Pastabos:</label>
                <textarea wire:model='note' class="border-2 border-black rounded-md @error('note') is-invalid @enderror" name="note" cols="30" rows="5"></textarea>
                @error('note')
                    <span class="text-red-600 mt-2">{{ $message }}</span>
                @enderror 
            </div>
    
            <button class="bg-black text-white px-10 py-2 rounded-md hover:bg-black/90" type="submit">Siųsti</button>
        </form>

        {{-- Success --}}
        @if (session()->has('success'))
            <p class="bg-green-600 text-white text-lg max-w-[500px] mx-auto rounded-md p-2 mt-4">{{ session('success') }}</p>
        @endif
        </div>

    {{-- Displaying results form contact form --}}
    <div class="text-center my-4">
        <h1 class="text-3xl py-4 font-bold">Kontaktų formos rezultatai:</h1>
        
        {{-- Search input and filters--}}
        @if ($users->count() > 0)
        <div>
            {{-- Filters --}}
            <div class="flex flex-col items-center gap-4"> 
                <label>
                    <input type="checkbox" wire:model="filterSuperUser">
                    Super User
                </label>
                <label>
                    <input type="checkbox" wire:model="filterNotSuperUser">
                    Ne Super User
                </label>
            </div>
            
            <input wire:model.live.debounce.500ms='search' class="border-2 border-black p-1 rounded-md my-4 w-[300px]"  type="text" name="search" placeholder="Ieškoti vartotojų pagal vardą">
            </div>
        @endif
        
        @forelse ($users as $user)
        {{-- EDITING form --}}
        @if ($editUser)
            <form wire:submit.prevent='update()' class="bg-slate-200 p-2">
                <h1 class="font-bold text-red-600 p-2">Redaguoti kontaktus</h1>
                @csrf
                <div class="flex flex-col justify-center items-center">
                    <label class="text-xl font-bold" for="name">Vardas:</label>
                    <input wire:model='name' class="border-2 border-black rounded-md p-1 w-[300px] @error('name') is-invalid @enderror" type="text" name="name" placeholder="Įveskite savo vardą">
                    {{-- Error --}}
                    @error('name')
                        <span class="text-red-600 mt-2">{{ $message }}</span>
                    @enderror
                </div>
        
                <div class="flex flex-col justify-center items-center">
                    <label class="text-xl font-bold" for="surname">Pavardė:</label>
                    <input wire:model='surname' class="border-2 border-black rounded-md p-1 w-[300px] @error('surname') is-invalid @enderror" type="text" name="surname" placeholder="Įveskite savo pavardę">
                    {{-- Error --}}
                    @error('surname')
                        <span class="text-red-600 mt-2">{{ $message }}</span>
                    @enderror
                </div>
        
                <div class="flex flex-col justify-center items-center">
                    <label class="text-xl font-bold" for="phone">Telefonas:</label>
                    <input wire:model='phone' class="border-2 border-black rounded-md p-1 w-[300px] @error('phone') is-invalid @enderror" type="tel" name="phone" pattern="(\+370|)[6-9]\d{7}" title="Įveskite galiojantį tel numerį, pvz: +37063333333" placeholder="Įveskite savo telefono numerį">
                    {{-- Error --}}
                    @error('phone')
                        <span class="text-red-600 mt-2">{{ $message }}</span>
                    @enderror
                </div>
        
                <div class="flex flex-col justify-center items-center">
                    <label class="text-xl font-bold" for="address">Adresas:</label>
                    <input wire:model='address' class="border-2 border-black rounded-md p-1 w-[300px] @error('address') is-invalid @enderror" type="text" name="address" placeholder="Įveskite savo telefono numerį">
                    {{-- Error --}}
                    @error('address')
                        <span class="text-red-600 mt-2">{{ $message }}</span>
                    @enderror
                </div>
        
                <div class="flex flex-col justify-center items-center">
                    <label class="text-xl font-bold" for="profile_photo">Nuotrauka:</label>
                    <input wire:model='profile_photo' class="bg-slate-500 text-white rounded-md" type="file" name="profile_photo">
                    {{-- Photo preview --}}
                    @if ($profile_photo)
                        <span class="text-indigo-600 font-bold text-lg">Failo peržiūra:</span>
                        <img src="{{ $profile_photo->temporaryUrl() }}" alt="photo">
                    @endif
                </div>
        
                <div class="flex flex-col justify-center items-center">
                    <label class="text-xl font-bold" for="roles">Pasirinkite rolę:</label>
                    <select wire:model='role' class="border-2 border-black rounded-sm @error('role') is-invalid @enderror" name="role">
                        <option value="Svečias" selected>Svečias</option>
                        <option value="Klientas">Klientas</option>
                        <option value="Administratorius">Admin (super user)</option>
                        <option value="Programuotojas">Programuotojas (super user)</option>
                    </select>
                    @error('role')
                        <span class="text-red-600 mt-2">{{ $message }}</span>
                    @enderror 
                </div>
    
                <div class="flex flex-col justify-center items-center">
                    <label class="text-xl font-bold" for="notes">Pastabos:</label>
                    <textarea wire:model='note' class="border-2 border-black rounded-md @error('note') is-invalid @enderror" name="note" cols="30" rows="5"></textarea>
                    @error('note')
                        <span class="text-red-600 mt-2">{{ $message }}</span>
                    @enderror 
                </div>
                
                {{-- Update Delete buttons --}}
                <button class="bg-green-600 text-white px-10 py-2 rounded-md hover:bg-green-600/90 my-2" type="submit">Atnaujinti</button>
                <button class="bg-red-600 text-white px-10 py-2 rounded-md hover:bg-red-600/90 my-2" wire:click='cancelEdit()'>Atšaukti redagavimą</button>
            </form>
        @endif
        {{-- EDITINGform --}}


            {{-- Users --}}
            <div wire:key='{{ $user->id }}' class="border-4 border-black rounded-md p-4 my-10 max-w-[500px] mx-auto">
                <h1 class="text-2xl font-semibold py-4">{{ $user->name . ' ' . $user->surname }}</h1>
                <p class="italic">Telefonas: {{ $user->phone }}</p>
                {{-- Picture check --}}
                @if ($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="photo" class="max-w-[300px] mx-auto">
                @else
                <p class="py-2 text-blue-600">Nėra paveikslėlio</p>
                @endif
                <button wire:click='edit({{ $user->id }})' class="bg-blue-600 text-white font-semibold p-2 rounded-md hover:bg-blue-600/90" href="">Redaguoti</button>
                <button wire:click='delete({{ $user->id }})' class="bg-red-600 text-white font-semibold p-2 rounded-md hover:bg-red-600/90" href="">Trinti</button>
                <div class="my-4">
                    <h1 class="font-semibold text-indigo-600">Rolė:</h1>
                    <p class="bg-black text-white p-1 rounded-md">{{ $user->role }}</p>
                </div>
                <div class="my-4">
                    <h1 class="font-semibold text-indigo-600">Pastabos:</h1>
                    <p class="">{{ $user->note }}</p>
                </div>
                <p class="text-xs text-slate-600">Sukurta: {{ $user->created_at }}</p>
            </div>
        @empty
            <p>Nėra duomenų iš kontaktų formos. Prašome užpildyti formą.</p>
            @endforelse
        </div>

        {{-- Success delete message--}}
        @if (session()->has('delete'))
            <p class="bg-red-600 text-white text-center text-lg max-w-[500px] mx-auto rounded-md p-2 my-4">{{ session('delete') }}</p>
        @endif

        <div class="border border-red-600">
            {{-- Pagination --}}
            {{ $users->links('pagination::tailwind') }}
        </div>
</div>
