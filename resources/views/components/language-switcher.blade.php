<div x-data="{ open: false }" class="relative inline-block text-left">
    <button @click="open = !open"
        class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        🌐 {{ strtoupper(app()->getLocale()) }}
        <svg class="ml-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.354a.75.75 0 111.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
        </svg>
    </button>

    <div x-show="open" @click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-40 origin-top-right bg-white border border-gray-200 rounded-md shadow-lg z-50">
        <form action="{{ route('language.switch') }}" method="POST">
            @csrf
            <button type="submit" name="locale" value="en"
                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 {{ app()->getLocale() == 'en' ? 'font-semibold' : '' }}">
                English
            </button>
            <button type="submit" name="locale" value="km"
                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 {{ app()->getLocale() == 'km' ? 'font-semibold' : '' }}">
                ភាសាខ្មែរ
            </button>
        </form>
    </div>
</div>