<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6 text-gray-900">
                    @if($posts->count())
                        @foreach($posts as $post)
                            <x-post-item :post="$post" />
                        @endforeach
                        
                        <div class="mt-4">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <p>You haven't any posts yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>