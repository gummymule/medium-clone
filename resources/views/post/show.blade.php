<x-app-layout> 
    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-4xl mb-6 font-bold">{{ $post->title }}</h1>

                {{-- User Avatar  --}}
                <div class="flex gap-4">
                    <x-user-avatar :user="$post->user" />
                    <div>
                        <x-follow-section :user="$post->user" class="flex gap-2">
                            <a href="{{ route('profile.show', $post->user) }}" class="hover:underline">
                                {{ $post->user->name }}
                            </a>
                            &middot;
                            <button 
                                x-text="isFollowing ? 'Unfollow' : 'Follow'" 
                                :class="isFollowing ? 'text-red-600 hover:text-red-500' : 'text-emerald-600 hover:text-emerald-500'"
                                @click="follow()">
                            </button>
                        </x-follow-section>
                        <div class="flex gap-2 text-gray-500 text-sm">
                            {{ $post->readTime() }} min read
                            &middot;
                            {{ $post->created_at->format('M d, Y') }}
                        </div>
                    </div>
                    
                    
                </div>
                {{-- User Avatar --}}

                {{-- Clap section --}}
                <x-clap-button :post="$post" />
                {{-- Clap section --}}

                {{-- Content Section --}}
                <div class="mt-8">
                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full max-h-64 object-cover">
                    <div class="mt-4">
                        {{ $post->content }}
                    </div>
                </div>
                {{-- Content Section --}}

                <div class="mt-10">
                    <span class="px-4 py-2 text-md bg-gray-200 rounded-2xl">
                        {{ $post->category->name }}
                    </span>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
