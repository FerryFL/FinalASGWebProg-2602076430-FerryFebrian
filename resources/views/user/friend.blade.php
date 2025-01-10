@extends('layout.master')

@section('title', 'Friends Page')

@section('content')
    <div class="container mt-5">
        <h4>@lang('lang.friend_list')</h4>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($acceptedFriends as $friendship)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ asset('lightborn.jpg') }}" class="card-img-top mx-auto"
                            style="width: 8rem; height: 8rem;">
                        <div class="card-body">
                            <h5 class="mb-2">@lang('lang.name'):
                                {{ $friendship->sender_id == Auth::id() ? $friendship->receiver->name : $friendship->sender->name }}
                            </h5>
                            <p class="mb-2">@lang('lang.hobbies'):
                                {{ $friendship->sender_id == Auth::id() ? $friendship->receiver->hobbies : $friendship->sender->hobbies }}
                            </p>
                            <p class="mb-2">@lang('lang.gender_value'):
                                {{ $friendship->sender_id == Auth::id() ? $friendship->receiver->gender : $friendship->sender->gender }}
                            </p>
                            <a href="{{ route('showChat', ['id' => $friendship->id]) }}" class="btn btn-primary">
                                @lang('lang.chat')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p>@lang('lang.no_accepted_friends')</p>
            @endforelse
        </div>

        <h4 class="mt-4">@lang('lang.pending_friend_requests')</h4>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($pendingRequests as $request)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ $request->sender->profile_picture ?: asset('assets/default-profile.jpg') }}"
                            class="card-img-top mx-auto" style="width: 8rem; height: 8rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $request->sender->name }}</h5>
                            <p class="card-text">@lang('lang.pending_request')</p>
                            <form method="POST" action="{{ route('acceptFriend', $request->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success">@lang('lang.accept')</button>
                            </form>
                            <form method="POST" action="{{ route('declineFriend', $request->id) }}" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-danger">@lang('lang.decline')</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p>@lang('lang.no_pending_requests')</p>
            @endforelse
        </div>
    </div>
@endsection
