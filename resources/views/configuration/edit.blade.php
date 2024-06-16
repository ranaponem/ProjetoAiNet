@extends('layouts.main')

@section('header-title', 'Price Configuration')

@section('main')


    <div class="mt-6 space-y-4">
        <section>

            <form id="configuration-form" method="post" action="{{ route('configuration.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                @csrf
                @method('patch')
        
                <div class="p-6 sm:px-10 bg-gray-800 flex">
                    <div class="grow w-2/3 mt-9 space-y-4 inline-block mr-10">
                        <x-field.input name="ticket_price" label="Ticket Price"
                                       value="{{ old('ticket_price', $conf->ticket_price) }}"/>
                    </div>
                    <div class="grow w-2/3 mt-9 space-y-4 inline-block mr-10">
                        <x-field.input name="registered_customer_ticket_discount" label="Discount for registered users"
                                       value="{{ old('registered_customer_ticket_discount', $conf->registered_customer_ticket_discount) }}"/>
                    </div>
                </div>
                @can('update', 'configuration')
                <div class="flex items-center gap-4 ">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
        
                    @if (session('status') === 'configuration-created')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
                @endcan
            </form>
        </section>
    </div>
@endsection
