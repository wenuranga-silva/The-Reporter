<section>
    <header>
        <h2 class="text-lg font-medium text-blck-900">
            Profile Description
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Update your profile description
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.add.description') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="description" />
            <textarea id="description" name="description" class="mt-1 block w-full"  required autofocus>{{ Auth::user()->userDesc != null ? Auth::user()->userDesc->description : '' }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
