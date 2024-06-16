<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Lista de Bilhetes') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Visualize as informações de perfil dos utilizadores.") }}
        </p>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Bar and Filters -->
            <div class="mb-6">
                <form action="{{ route('users.index') }}" method="GET" class="flex justify-center space-x-4">
                    <input type="text" name="search" placeholder="{{ __('Search users...') }}"
                           value="{{ request('search') }}"
                           class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 w-full md:w-1/3">
                    <button type="submit"
                            class="inline-block px-4 py-2 rounded-md text-gray-900 bg-white hover:bg-gray-300 transition duration-200">
                        {{ __('Search') }}
                    </button>
                </form>
            </div>

            <div class="flex justify-center space-x-4 mt-6">
                <a href="{{ route('users.index') }}"
                   class="inline-block px-4 py-2 rounded-md text-gray-400 transition duration-200 {{ request('type') == null ? 'bg-white hover:bg-gray-300' : 'bg-gray-800 hover:bg-gray-700' }}">
                    {{ __('All') }}
                </a>
                <a href="{{ route('users.index', ['type' => 'A']) }}"
                   class="inline-block px-4 py-2 rounded-md text-gray-400 transition duration-200 {{ request('type') == 'A' ? 'bg-white hover:bg-gray-300' : 'bg-gray-800 hover:bg-gray-700' }}">
                    {{ __('Admins') }}
                </a>
                <a href="{{ route('users.index', ['type' => 'E']) }}"
                   class="inline-block px-4 py-2 rounded-md text-gray-400 transition duration-200 {{ request('type') == 'E' ? 'bg-white hover:bg-gray-300' : 'bg-gray-800 hover:bg-gray-700' }}">
                    {{ __('Employees') }}
                </a>
                <a href="{{ route('users.index', ['type' => 'C']) }}"
                   class="inline-block px-4 py-2 rounded-md text-gray-400 transition duration-200 {{ request('type') == 'C' ? 'bg-white hover:bg-gray-300' : 'bg-gray-800 hover:bg-gray-700' }}">
                    {{ __('Customers') }}
                </a>
            </div>

            <div class="grid grid-cols-1 gap-4 mt-6">
                @foreach($tickets as $ticket)
                    
                @endforeach
            </div>
        </div>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('users.destroy', $user) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete this account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once this account is deleted, all of its resources and data will be permanently deleted.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</x-app-layout>
