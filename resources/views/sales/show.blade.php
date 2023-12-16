<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Invoice ID : ' . $sale->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end mb-8">
                        <span class="text-sm">Sold At: {{ $sale->created_at }}</span>
                    </div>
                    <div class="flex justify-center">
                        <table class="table-auto rounded-md">
                            <thead class="bg-gray-100">
                              <tr>
                                <th class="py-4 px-8">ID</th>
                                <th class="py-4 px-8">S/N</th>
                                <th class="py-4 px-8">Product Title</th>
                                <th class="py-4 px-8">Selling Price</th>
                                <th class="py-4 px-8">Units Sold</th>
                                <th class="py-4 px-8">Total Price</th>
                              </tr>
                            </thead>
                            <tbody class="bg-orange-50">
                              <tr>
                                <td class="py-4 px-8">{{ $sale->id }}</td>
                                <td class="py-4 px-8">{{ $sale->serial_number }}</td>
                                <td class="py-4 px-8">{{ $sale->title }}</td>
                                <td class="py-4 px-8">{{ $sale->selling_price }}</td>
                                <td class="py-4 px-8">{{ $sale->unit }}</td>
                                <td class="py-4 px-8">{{ $sale->total }}</td>
                              </tr>
                            </tbody>
                          </table>
                    </div>
                    <div class="flex justify-center mt-12">
                        <a class="mt-1" href="{{ route('sale.create', ['product_id' => $sale->product_id]) }}">
                            <span class="px-4 py-3 rounded-md bg-green-500/75 hover:bg-green-500 text-sm text-extrabold text-white">
                                SELL THIS PRODUCT AGAIN
                            </span>
                        </a>
                        &nbsp;
                        <x-danger-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-invoice-deletion')"
                        >{{ __('Return To Inventory') }}</x-danger-button>
                    </div>

                    <x-modal name="confirm-invoice-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                        <form method="post" action="{{ route('sale.destroy', $sale->id) }}" class="p-6">
                            @csrf
                            @method('delete')

                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Delete this invoice and return the product back to inventory?') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Notice: Once this invoice is deleted, all of its resources and data will be permanently deleted.') }}
                            </p>

                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-danger-button class="ms-3">
                                    {{ __('Return Product') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
