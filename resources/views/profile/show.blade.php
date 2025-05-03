<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex">
                    <div class="flex-1 pr-8">
                        <h1 class="text-4xl">{{ $user->name }}</h1>

                        <div class="mt-8">
                            @forelse ($posts as $post)
                                <x-post-item :post="$post" />
                            @empty
                                <div>
                                    <p class="text-center text-gray-500 py-16">No posts found</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                   <x-follow-section :user="$user">
                        <x-user-avatar :user="$user" size="w-24 h-24" />
                        <h3 class="mt-4">{{ $user->name }}</h3>
                        <p class="text-gray-500">
                            <span x-text="followersCount"></span> Followers
                        </p>
                        <p>{{ $user->bio }}</p>
                        @if (auth()->user() && auth()->user()->id !== $user->id)
                        <div class="mt-4">
                            <button 
                                @click="follow()"
                                class="text-white px-4 py-2 rounded-full transition duration-200"
                                x-text="isFollowing ? 'Unfollow' : 'Follow'"
                                :class="isFollowing ? 'bg-red-600 hover:bg-red-500' : 'bg-emerald-600 hover:bg-emerald-500'"
                            ></button>
                        </div>
                        @endif
                    </x-follow-section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
