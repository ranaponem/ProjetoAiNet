<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Payment methods') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Update Default Payment Method') }}
                        </h2>
                    </header>

                    <form method="post" action="{{ route('customers.update', ['customer'=>$customer]) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            
                            <x-input-label for="Payment type" :value="__('Payment type')" class="mb-6"/>
                            <input type="radio" id="visa" name="Payment_type" value="VISA" @if ($customer->payment_type === 'VISA') checked @endif >
                            <label for="visa" class="text-gray-300 ml-2">VISA</label><br>
                            <input type="radio" id="mbway" name="Payment_type" value="MBWAY" @if ($customer->payment_type === 'MBWAY') checked @endif>
                            <label for="mbway" class="text-gray-300 ml-2">MBWAY</label><br>
                            <input type="radio" id="paypal" name="Payment_type" value="PAYPAL" @if ($customer->payment_type === 'PAYPAL') checked @endif>
                            <label for="paypal" class="text-gray-300 ml-2">PAYPAL</label>
                            <x-input-error class="mt-2" :messages="$errors->get('Payment_type')" />

                            
                            
                        </div>
                        
                        <div>   
                            <x-input-label for="Payment Reference" :value="__('Payment Reference')" />
                            <x-text-input id="Payment_Reference" name="Payment_Reference" type="text" class="mt-1 block w-full" :value="old('Payment_Reference', $customer->payment_ref)" required  autocomplete="payment_ref" />
                            <x-input-error class="mt-2" :messages="$errors->get('Payment_Reference')" />
                        </div>
                        <div>
                            
                            <x-input-label for="nif" :value="__('NIF')" />
                            <x-text-input id="nif" name="nif" type="text" class="mt-1 block w-full" :value="old('nif', $customer->nif)" required  autocomplete="nif" />
                            <x-input-error class="mt-2" :messages="$errors->get('nif')" />
                        </div>

                        

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            
                            @if (session('status') === 'password-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >{{ __('Saved.') }}</p>
                            @endif
                            <x-secondary-button :href="route('profile.edit')">{{ __('Cancel') }}</x-secondary-button>
                        </div>
                    </form>
                </section>

                </div>
            </div>
            
            
        </div>
    </div>
</x-app-layout>