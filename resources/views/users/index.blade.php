<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Users') }}
            </h2>
            <a href="{{ route('users.create') }}" class="px-3 py-2 text-sm text-white rounded-md bg-slate-800 hover:bg-slate-700">Add User</a>
        </div>
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- @include('components.message') --}}
            <div>
                <x-message></x-message>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Role</th>
                        <th class="px-6 py-3 text-left">Created</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($users->isNotEmpty())
                    @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="px-6 py-3 text-left">{{ $user->id }}</td>
                        <td class="px-6 py-3 text-left">{{ $user->name }}</td>
                        <td class="px-6 py-3 text-left">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-3 text-left">00</td>
                        <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y')}}</td>
                        <td class="px-6 py-3 text-center justify-center flex gap-1">
                            <a href="{{ route('user.addToRole',$user->id) }}" class="px-3 py-2 text-sm tracking-normal text-white rounded-lg bg-orange-300 hover:bg-orange-400">Add To Role</a>
                            <a href="{{ route('users.edit',$user->id) }}" class="px-3 py-2 text-sm tracking-normal text-white rounded-lg bg-green-600 hover:bg-green-700">Edit</a>
                            <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="px-3 py-2 text-sm tracking-normal text-white rounded-lg bg-red-600 hover:bg-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    
                </tbody>
            </table>
            <div class="py-3">
                @if ($users->isNotEmpty())
                    {{ $users->links() }}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>