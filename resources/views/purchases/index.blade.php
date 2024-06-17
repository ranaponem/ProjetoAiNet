@extends('layouts.main')

@section('header-title', 'All Purchases')

@section('main')
    <div class="container mx-auto p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <h1 class="text-2xl mb-6">All Purchases</h1>

        @if (session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        @if ($purchases->isEmpty())
            <p>No purchases found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Customer Name
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Total Price
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Payment Type
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800">
                    @foreach ($purchases as $purchase)
                        <tr>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                {{ $purchase->customer_name }}
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                {{ $purchase->customer_email }}
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                {{ $purchase->date }}
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                {{ number_format($purchase->total_price, 2) }}€
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                {{ $purchase->payment_type }}
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <div class="mt-4">
            {{ $purchases->links() }}
        </div>
    </div>
@endsection
