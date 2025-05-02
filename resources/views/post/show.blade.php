<x-app-layout> 
    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-4xl mb-6 font-bold">{{ $post->title }}</h1>

                {{-- User Avatar  --}}
                <div class="flex gap-4">
                    <x-user-avatar :user="$post->user" />
                    <div>
                        <div class="flex gap-2">
                            <a href="{{ route('profile.show', $post->user) }}" class="hover:underline">
                                {{ $post->user->name }}
                            </a>
                            &middot;
                            <a href="#" class="text-emerald-500">
                                <h3 >Follow</h3>
                            </a>
                        </div>
                        <div class="flex gap-2 text-gray-500 text-sm">
                            {{ $post->readTime() }} min read
                            &middot;
                            {{ $post->created_at->format('M d, Y') }}
                        </div>
                    </div>
                    
                    
                </div>
                {{-- User Avatar --}}

                {{-- Clap section --}}
                <x-clap-button />
                {{-- Clap section --}}

                {{-- Content Section --}}
                <div class="mt-8">
                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full max-h-64 object-cover">
                    <div class="mt-4">
                        {{ $post->content }}
                    </div>
                </div>
                {{-- Content Section --}}

                <div class="mt-6">
                    <span class="px-4 py-2 text-md bg-gray-200 rounded-2xl">
                        {{ $post->category->name }}
                    </span>
                    {{-- Clap section --}}
                    <x-clap-button />
                    {{-- Clap section --}}    
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
