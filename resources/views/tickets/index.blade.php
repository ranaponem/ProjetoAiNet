<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Ticket List') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __("View all tickets ever registered") }}
                </p>
            </div>

        </div>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Bar and Filters -->
            <div class="mb-6">
                <form action="{{ route('tickets.index') }}" method="GET" class="flex justify-center space-x-4">
                    <input type="text" name="search" placeholder="{{ __('Search tickets by customer...') }}"
                           value="{{ request('search') }}"
                           class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 w-full md:w-1/3">
                    <button type="submit"
                            class="inline-block px-4 py-2 rounded-md text-gray-900 bg-white hover:bg-gray-300 transition duration-200">
                        {{ __('Search') }}
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 gap-4 mt-6">
                @foreach($tickets as $ticket)
                    <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg flex">
                        <div class="p-6 sm:px-20 bg-gray-800 border-b border-gray-600 w-full">
                            <h3 class="inline-block font-bold text-3xl text-black dark:text-gray-50 mb-5">Ticket {{$ticket->id}}</h3>
                            <div>
                                <x-input-label for="customerName" :value="__('Customer Name')" />
                                <x-text-input id="customerName" name="customerName" type="text" class="mt-1 block w-full"
                                              :value="$ticket->purchase->customer_name" required autofocus autocomplete="customerName" disabled />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="mt-6">
                                <x-input-label for="movie" :value="__('Movie')" />
                                <x-text-input id="movie" name="movie" type="text" class="mt-1 block w-full"
                                              :value="$ticket->screening->movie->title" required autocomplete="movie" disabled />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div class="mt-6">
                                <x-input-label for="price" :value="__('Price')" />
                                <x-text-input id="price" name="price" type="text" class="mt-1 block w-full"
                                              :value="$ticket->price" required disabled />
                                <x-input-error class="mt-2" :messages="$errors->get('type')" />
                            </div>
                            <div class="flex">
                                @if( $ticket->id !== auth()->id())
                                    <div class="mt-6 inline-block ml-2">
                                        <x-danger-button class="py-3"
                                                         x-data=""
                                                         x-on:click.prevent="$dispatch('open-modal', 'confirm-ticket-deletion')"
                                        >{{ __('Delete Ticket') }}</x-danger-button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $tickets->links() }}
            </div>
        </div>  
    </div>

    <x-modal name="confirm-ticket-deletion" :show="$errors->ticketDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('tickets.destroy', $ticket) }}" class="p-6">
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
                    {{ __('Delete Ticket') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    
</x-app-layout>