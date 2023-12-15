<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Make A Sale') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2>{{ $product->title }}</h2>
                    <form method="post" action="{{ route('sale.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <input name="product_id" type="number" value="{{ $product->id }}" hidden />

                        <div>
                            <x-input-label :value="__('Price')" />
                            <p class="py-2 px-3 bg-green-100 rounded">{{ $product->price }}</p>
                        </div>

                        <div>
                            <x-input-label :value="__('Stock')" />
                            <p class="py-2 px-3 bg-green-100 rounded">{{ $product->stock }}</p>
                        </div>

                        <div>
                            <x-input-label for="unit" :value="__('Units To Sell')" />
                            <x-text-input id="unit" name="unit" type="number" :value="old('unit', '1')" class="mt-1 block w-full" min="1" max="{{ $product->stock }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('unit')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Sell') }}</x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
