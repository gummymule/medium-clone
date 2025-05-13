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
                            @if (auth()->id() !== $post->user->id)
                            &middot;
                                <button 
                                    x-text="isFollowing ? 'Unfollow' : 'Follow'" 
                                    :class="isFollowing ? 'text-red-600 hover:text-red-500' : 'text-emerald-600 hover:text-emerald-500'"
                                    @click="follow()">
                                </button>
                            @endif
                        </x-follow-section>
                        <div class="flex gap-2 text-gray-500 text-sm">
                            {{ $post->readTime() }} min read
                            &middot;
                            {{ $post->created_at->format('M d, Y') }}
                        </div>
                    </div>
                    
                    
                </div>
                {{-- User Avatar --}}

                @if ($post->user_id === Auth::id())
                <div class="py-4 mt-8 border-t border-b border-gray-200">
                    <a href="{{ route('post.edit', $post->slug) }}">
                        <button class="inline-flex gap-2 items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            Edit
                        </button>
                    </a>
                    <form class="inline-block" action="{{ route('post.destroy', $post) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="inline-flex gap-2 items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-500 bg-white hover:text-red-700 focus:outline-none transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>                          
                            Delete
                        </button>
                    </form>
                </div>
                @endif

                {{-- Clap section --}}
                <x-clap-button :post="$post" />
                {{-- Clap section --}}

                {{-- Content Section --}}
                <div class="mt-8">
                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full object-cover">
                    <div class="mt-4 px-4 prose max-w-4xl">
                        <style>
                            .prose p {
                                text-align: justify !important;
                                justify-content: center !important;
                                line-height: 32px !important;
                                margin: 2rem 0;
                            }
                            .prose pre {
                                max-width: 80%;
                                text-wrap: wrap;
                            }
                            .prose figure {
                                margin: 2rem 0 !important; /* Atur jarak atas-bawah */
                            }
                            .prose img {
                                display: block;
                                justify-content: center !important;
                                margin: 2rem auto;
                                max-width: 100%;
                                height: auto;
                            }
                        </style>
                        {!! $post->content !!}
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
