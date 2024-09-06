<x-app-layout>
    <x-slot name="header">
        
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User/Create') }}
            </h2>
            <a href="{{ route('users.index') }}" class="px-3 py-2 text-sm text-white rounded-md bg-slate-800 hover:bg-slate-700">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="my-2">
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                                <input name="name" type="text" placeholder="Enter your role name" class="w-1/2 border rounded-lg border-blue-500" value="{{ old('name') }}">
                                @error('name')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="my-2">
                                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                                <input name="email" type="text" placeholder="Enter your email" class="w-1/2 border rounded-lg border-blue-500" value="{{ old('email') }}">
                                @error('email')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="my-2">
                                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                                <input name="password" type="text" placeholder="Enter your password" class="w-1/2 border rounded-lg border-blue-500">
                                @error('password')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="my-2">
                                <label for="confirm_password" class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
                                <input name="confirm_password" type="text" placeholder="Enter your confirm_password" class="w-1/2 border rounded-lg border-blue-500">
                                @error('confirm_password')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
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