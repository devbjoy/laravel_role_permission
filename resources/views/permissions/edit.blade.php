<x-app-layout>
    <x-slot name="header">
        
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permission/Edit') }}
            </h2>
            <a href="{{ route('permission.index') }}" class="px-3 py-2 text-sm text-white rounded-md bg-slate-800 hover:bg-slate-700">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <form action="{{ route('permission.update',$permission->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="my-2">
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                                <input value="{{ $permission->name }}" name="name" type="text" placeholder="Enter Your Permission Name" class="w-1/2 border rounded-lg border-blue-500">
                                @error('name')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-2"> 
                                <button type="submit" class="px-3 py-3 text-sm tracking-normal text-white rounded-lg bg-slate-800 hover:bg-slate-700">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>