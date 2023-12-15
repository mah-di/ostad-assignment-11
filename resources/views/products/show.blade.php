<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-2xl">Title: {{ $product->title }}</p><br>
                    @if ($product->description !== null)
                        <p class="text-2xl">Description: {{ $product->description }}</p><br>
                    @endif
                    <p class="text-2xl">Price: {{ $product->price }}</p><br>
                    <p class="text-2xl">Stock: {{ $product->stock }}</p><br>
                    <p class="text-2xl">S/N: {{ $product->serial_number }}</p><br>
                    <p class="text-2xl">Date Added: {{ $product->created_at }}</p><br><br>
                    <a class="" href="{{ route('product.edit', $product->id) }}">
                        <span class="px-4 py-2 rounded-md bg-sky-500/75 hover:bg-sky-500 text-sm text-extrabold text-white">
                            UPDATE THIS PRODUCT
                        </span>
                    </a>
                    &nbsp;
                    <x-danger-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-product-deletion')"
                    >{{ __('Delete This Product') }}</x-danger-button>

                    <x-modal name="confirm-product-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                        <form method="post" action="{{ route('product.destroy', $product->id) }}" class="p-6">
                            @csrf
                            @method('delete')

                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Are you sure you want to delete this product?') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Notice: Once this product is deleted, all of its resources and data will be permanently deleted.') }}
                            </p>

                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-danger-button class="ms-3">
                                    {{ __('Delete Product') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
