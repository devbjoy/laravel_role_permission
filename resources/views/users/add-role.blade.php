<x-app-layout>
    <x-slot name="header">
        
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User To Role Added') }}
            </h2>
            <a href="{{ route('users.index') }}" class="px-3 py-2 text-sm text-white rounded-md bg-slate-800 hover:bg-slate-700">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <form action="{{ route('user.addToRoleProcess',$user->id) }}" method="POST">
                            @csrf
                            <div class="my-2">
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">User Name</label>
                                <input value="{{ $user->name }}" name="name" type="text" placeholder="Enter your role name" class="w-1/2 border rounded-lg border-blue-500">
                                @error('name')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-4 mb-2">
                                @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)
                                <div class="mt-3">
                                    <input {{ ($hasRoles->contains($role->name)) ? 'checked' : '' }} class="rounded" type="checkbox" name="role[]" value="{{ $role->name }}" id="role-.{{$role->id}}">
                                    <label for="role-.{{ $role->id }}" class="text-sm">{{ $role->name}}</label>
                                </div>
                                @endforeach
                                @endif
                                
                            </div>
                            <div class="mt-2"> 
                                <button type="submit" class="px-3 py-3 text-sm tracking-normal text-white rounded-lg bg-slate-800 hover:bg-slate-700">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>