@extends('backend.layouts.app')

@section('title')
    {{ __('Permission Details') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Permission Details') }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                        {{ __('Home') }}
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.permissions.index') }}">
                        {{ __('Permissions') }}
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Details') }}</li>
            </ol>
        </nav>
    </div>

    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-t border-gray-100 dark:border-gray-800 p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Permission Name') }}</h4>
                            <p class="mt-1 text-lg font-medium text-gray-800 dark:text-white">{{ $permission->name }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Permission Group') }}</h4>
                            <p class="mt-1">
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-white">
                                    {{ $permission->group_name }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Assigned Roles') }}</h4>
                        @if($roles->count() > 0)
                            <div class="space-y-2">
                                @foreach($roles as $role)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                        <div class="flex items-center">
                                            <span class="text-gray-800 dark:text-white">{{ $role->name }}</span>
                                        </div>
                                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-primary hover:underline text-sm">
                                            <i class="bi bi-eye mr-1"></i> {{ __('View Role') }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg text-center">
                                <span class="text-gray-500 dark:text-gray-400">{{ __('No roles have this permission') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
