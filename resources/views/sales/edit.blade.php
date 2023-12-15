<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="post" action="{{ route('product.update', $product->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" :value="old('title', $product->title)" class="mt-1 block w-full" required autofocus autocomplete="title" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" name="description" type="text" :value="old('description', $product->description)" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" name="price" type="number" step="0.01" :value="old('price', $product->price)" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                        </div>

                        <div>
                            <x-input-label :value="__('Current Stock')" />
                            <x-text-input name="current_stock" type="number" :value="$product->stock" hidden />
                            <p class="py-2 px-3 bg-orange-100 rounded">{{ $product->stock }}</p>
                        </div>

                        <div>
                            <x-input-label for="new_stock" :value="__('Add Stock')" />
                            <x-text-input id="new_stock" name="new_stock" type="number"  :value="old('new_stock', 0)" class="mt-1 block w-full bg-sky-100" />
                            <x-input-error class="mt-2" :messages="$errors->get('new_stock')" />
                        </div>

                        <div>
                            <x-input-label for="serial_number" :value="__('S/N')" />
                            <x-text-input id="serial_number" name="serial_number" :value="old('serial_number', $product->serial_number)" type="text" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('serial_number')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>

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
