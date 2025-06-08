@extends('backend.auth.layouts.app')

@section('title')
    {{ __('Sign Up') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
    <div>
        <div class="mb-5 sm:mb-8">
            <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">
                {{ __('Sign Up') }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('Create a new account to get started!') }}
            </p>
        </div>
        <div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="space-y-5">
                    @include('backend.layouts.partials.messages')

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Name') }} <span class="text-error-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                            autocomplete="name" placeholder="{{ __('Enter your name') }}"
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 @error('name') border-red-500 @enderror">

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Username') }} <span class="text-error-500">*</span>
                        </label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required
                            autocomplete="username" placeholder="{{ __('Enter your username') }}"
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 @error('username') border-red-500 @enderror">

                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Email Address') }} <span class="text-error-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            autocomplete="email" placeholder="{{ __('Enter your email') }}"
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 @error('email') border-red-500 @enderror">

                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Password') }} <span class="text-error-500">*</span>
                        </label>
                        <input type="password" name="password" id="password" required autocomplete="new-password"
                            placeholder="{{ __('Enter your password') }}"
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 @error('password') border-red-500 @enderror">

                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Confirm Password') }} <span class="text-error-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            autocomplete="new-password" placeholder="{{ __('Confirm your password') }}"
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">

                    </div>


                    <div>
                        <button type="submit"
                            class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                            {{ __('Sign Up') }}
                            <i class="bi bi-person-plus-fill ml-2"></i>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
