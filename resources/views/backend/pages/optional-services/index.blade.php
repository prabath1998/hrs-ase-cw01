@extends('backend.layouts.app')

@section('title')
    {{ __('Optional Services') }} | {{ config('app.name') }}
@endsection


@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Optional Services') }}</h3>

                    @include('backend.partials.search-form', [
                        'placeholder' => __('Search by name or email'),
                    ])

                    @if (auth()->user()->can('optional_service.manage'))
                        <a href="{{ route('admin.optional-services.create') }}" class="btn-primary">
                            <i class="bi bi-plus-circle mr-2"></i>
                            {{ __('New Optional Service') }}
                        </a>
                    @endif

                </div>


                <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                    @include('backend.layouts.partials.messages')
                    <table class="w-full dark:text-gray-400">
                        <thead class="bg-light text-capitalize">
                            <tr class="border-b border-gray-100 dark:border-gray-800 text-left">
                                <th class="p-3 px-5">{{ __('#') }}</th>
                                <th class="p-3 px-5">{{ __('Name') }}</th>
                                <th class="p-3 px-5">{{ __('Price') }}</th>
                                <th class="p-3 px-5">{{ __('Category') }}</th>
                                <th class="p-3 px-5">{{ __('Status') }}</th>
                                <th class="p-3 px-5 text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($services as $service)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-5 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-4">{{ $service->name }}</td>
                                    <td class="px-5 py-4">{{ number_format($service->price, 2) }}</td>
                                    <td class="px-5 py-4">{{ $service->category }}</td>
                                    <td class="px-5 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $service->is_active ? __('Active') : __('Inactive') }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('admin.optional-services.edit', $service->id) }}" class="btn-default !p-3" title="{{ __('Edit') }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <a data-modal-target="delete-modal-{{ $service->id }}" data-modal-toggle="delete-modal-{{ $service->id }}" class="btn-danger !p-3" href="javascript:void(0);">
                                                <i class="bi bi-trash text-sm"></i>
                                            </a>

                                            <!-- Delete Modal -->
                                            <div id="delete-modal-{{ $service->id }}" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center">
                                                <div class="relative p-4 w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-700 z-60">
                                                    <div class="p-4 md:p-5 text-center">
                                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                            {{ __('Are you sure you want to delete this service?') }}
                                                        </h3>
                                                        <form action="{{ route('admin.optional-services.destroy', $service->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-white bg-red-600 hover:bg-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                                {{ __('Yes, Confirm') }}
                                                            </button>
                                                            <button data-modal-hide="delete-modal-{{ $service->id }}" type="button"
                                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                                {{ __('No, cancel') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">{{ __('No optional services found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>


                    <div class="my-4 px-4 sm:px-6">
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
