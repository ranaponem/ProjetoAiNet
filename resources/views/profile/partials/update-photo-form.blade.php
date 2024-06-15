<section>
    <header>
        
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="p-6 sm:px-10 bg-gray-800  w-96">
                            <div class="flex justify-center">
                                @if($user->photo_filename)
                                    <img src="{{ $user->getImageUrlAttribute() }}" alt="Profile Picture"
                                         class="rounded-full h-48  w-48 object-cover">
                                @else
                                    <div class="rounded-full h-32 w-32 bg-gray-700 flex items-center justify-center text-gray-300">
                                        <span>{{ __('No Image') }}</span>
                                    </div>
                                @endif
                            </div>
        </div>
    </form>
</section>