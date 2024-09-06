<x-app-layout>
    <x-slot name="header">
        
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Article/Edit') }}
            </h2>
            <a href="{{ route('articles.index') }}" class="px-3 py-2 text-sm text-white rounded-md bg-slate-800 hover:bg-slate-700">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <form action="{{ route('articles.update',$article->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="my-2">
                                <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                                <input value="{{ $article->title }}" name="title" type="text" placeholder="Enter title" class="w-full border rounded-lg border-blue-500">
                                @error('title')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="my-2">
                                <label for="content" class="block text-sm font-medium text-slate-700 mb-1">Content</label>
                                <textarea cols="30" rows="10" name="content" type="text" placeholder="Enter content" class="w-full border rounded-lg border-blue-500 resize-none">
                                    {{ $article->content }}
                                </textarea>
                                @error('content')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="my-2">
                                <label for="author" class="block text-sm font-medium text-slate-700 mb-1">Author</label>
                                <input value="{{ $article->author }}" name="author" type="text" placeholder="Enter author name" class="w-full border rounded-lg border-blue-500">
                                @error('author')
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