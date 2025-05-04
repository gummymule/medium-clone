<div>
    <ul class="flex flex-wrap text-sm font-medium text-center 
    text-gray-500 justify-center">
        <li class="me-2">
            <a href="/"  
                class="{{ request('category') 
                ? 'inline-block px-4 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100'
                : 'inline-block px-4 py-2 text-white bg-blue-600 rounded-lg active' }} "
                aria-current="page"
            >
                All
            </a>
        </li>
        @forelse ($categories as $category)
            <li class="me-2">
                <a href="{{ route('post.byCategory', $category) }}" 
                    class="{{ (Route::currentRouteName() === 'post.byCategory' && request('category')->id == $category->id) 
                    ? 'inline-block px-4 py-2 text-white bg-blue-600 rounded-lg active' 
                    : 'inline-block px-4 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100' }}"
                >
                    {{ $category->name }}
                </a>
            </li>
        @empty
            {{ $slot }}
        @endforelse
    </ul>
</div>