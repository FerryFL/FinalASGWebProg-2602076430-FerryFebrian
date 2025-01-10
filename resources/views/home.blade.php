@extends('layout.master')
@section('title', 'Home Page')
@section('content')
    <div class="container mt-5">
        <!-- Search and Filter Form -->
        <form class="d-flex flex-row gap-2" method="GET" action="{{ route('home') }}" role="search">
            <input class="form-control me-2" type="search" name="search" placeholder="@lang('lang.search_placeholder')"
                value="{{ request('search') }}" aria-label="@lang('lang.search_placeholder')">
            <button class="btn btn-outline-success" type="submit">@lang('lang.search_button')</button>

            <!-- Gender Filter Dropdown -->
            <div class="dropdown d-flex align-items-center">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    @lang('lang.filter')
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-funnel-fill" viewBox="0 0 16 16">
                        <path
                            d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z" />
                    </svg>
                </button>
                <ul class="dropdown-menu">
                    @foreach ($genders as $gender)
                        <li><a class="dropdown-item"
                                href="{{ route('home', ['gender' => $gender]) }}">{{ ucfirst($gender) }}</a></li>
                    @endforeach
                    <li><a class="dropdown-item" href="{{ route('home') }}">@lang('lang.clear_filter')</a></li>
                </ul>
            </div>
        </form>

        <!-- Title for User List -->
        <h3 class="text-center my-4">@lang('lang.find_add_friends')</h3>

        <!-- Users Display Section -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($users as $user)
                @if ($user->id !== Auth::id())
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ $user->profile_picture ?: asset('lightborn.jpg') }}" class="card-img-top mx-auto"
                                style="width: 8rem; height: 8rem;">
                            <div class="card-body">
                                <h5 class="card-title">@lang('lang.name'): {{ $user->name }}</h5>
                                <p class="card-text">@lang('lang.hobbies'): {{ $user->hobbies }}</p>
                                <p class="card-text">@lang('lang.gender_value') {{ $user->gender }}</p>
                            </div>
                            <!-- Add Friend Button -->
                            <form method="POST" action="{{ route('addFriend', $user->id) }}">
                                @csrf
                                <button type="submit" class="m-3 btn btn-primary">@lang('lang.add_friend')</button>
                            </form>
                        </div>
                    </div>
                @endif
            @empty
                <p>@lang('lang.no_users_found')</p>
            @endforelse
        </div>
    </div>
@endsection
