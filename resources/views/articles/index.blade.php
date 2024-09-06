<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Article') }}
            </h2>
            @can('create article')
                <a href="{{ route('articles.create') }}" class="px-3 py-2 text-sm text-white rounded-md bg-slate-800 hover:bg-slate-700">Add Article</a>
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
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Title</th>
                        <th class="px-6 py-3 text-left">Description</th>
                        <th class="px-6 py-3 text-left">Author</th>
                        <th class="px-6 py-3 text-left">Created</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($articles->isNotEmpty())
                    @foreach ($articles as $article)
                    <tr class="border-b">
                        <td class="px-6 py-3 text-left">{{ $article->id }}</td>
                        <td class="px-6 py-3 text-left">{{ $article->title }}</td>
                        <td class="px-6 py-3 text-left">
                            {{ $article->content }}
                        </td>
                        <td class="px-6 py-3 text-left">{{ $article->author }}</td>
                        <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($article->created_at)->format('d M, Y')}}</td>
                        <td class="px-6 py-3 text-center justify-center flex gap-1">
                            @can('edit article')
                                <a href="{{ route('articles.edit',$article->id) }}" class="px-3 py-2 text-sm tracking-normal text-white rounded-lg bg-green-600 hover:bg-green-700">Edit</a>
                            @endcan
                            @can('delete article')
                            <form action="{{ route('articles.destroy',$article->id) }}" method="POST">
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
                @if ($articles->isNotEmpty())
                    {{ $articles->links() }}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>