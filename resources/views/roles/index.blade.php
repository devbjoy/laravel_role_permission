<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Roles') }}
            </h2>
            @can('create role')
                <a href="{{ route('roles.create') }}" class="px-3 py-2 text-sm text-white rounded-md bg-slate-800 hover:bg-slate-700">Add Role To Permission</a>
            @endcan
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
                        <th class="px-6 py-3 text-left" width="50">#</th>
                        <th class="px-6 py-3 text-left" width="150">Name</th>
                        <th class="px-6 py-3 text-left">Permission Name</th>
                        <th class="px-6 py-3 text-left" width="150">Created</th>
                        <th class="px-6 py-3 text-center" width="150">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($roles->isNotEmpty())
                    @foreach ($roles as $role)
                    <tr class="border-b">
                        <td class="px-6 py-3 text-left">{{ $role->id }}</td>
                        <td class="px-6 py-3 text-left">{{ $role->name }}</td>
                        <td class="px-6 py-3 text-left">
                            @if ($role->getPermissionNames()->isNotEmpty())
                            @foreach ($role->getPermissionNames() as $permission)
                                {{ $permission }} |
                            @endforeach
                            @endif
                        </td>

                        <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y')}}</td>
                        <td class="px-6 py-3 text-center justify-center flex gap-1">
                            @can('edit role')
                                <a href="{{ route('roles.edit',$role->id) }}" class="px-3 py-2 text-sm tracking-normal text-white rounded-lg bg-green-600 hover:bg-green-700">Edit</a>                               
                            @endcan
                            @can('delete role')
                            <form action="{{ route('roles.destroy',$role->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="px-3 py-2 text-sm tracking-normal text-white rounded-lg bg-red-600 hover:bg-red-700">Delete</button>
                            </form>   
                            @endcan
                            
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    
                </tbody>
            </table>
            <div class="py-3">
                @if ($roles->isNotEmpty())
                    {{ $roles->links() }}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>