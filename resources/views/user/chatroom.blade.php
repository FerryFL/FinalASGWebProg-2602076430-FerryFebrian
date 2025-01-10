@extends('layout.master')
@section('title', 'Chat Rooms')
@section('content')
    <div class="container mt-5">
        <h3 class="text-center mb-4">@lang('lang.your_friends')</h3>
        <div class="row">
            @foreach ($chatrooms as $chatroom)
                @php
                    $friend = $chatroom->user_id_1 === Auth::id() ? $chatroom->user2 : $chatroom->user1;
                @endphp
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="{{ asset('lightborn.jpg') }}" class="card-img-top mx-auto" class="card-img-top"
                            style="width: 8rem; height: 8rem;" alt="Profile Picture">
                        <div class="card-body">
                            <h5 class="card-title">{{ $friend->name }}</h5>
                            <p class="card-text">@lang('lang.hobbies'): {{ $friend->hobbies }}</p>
                            <a href="{{ route('showChat', ['id' => $chatroom->id]) }}" class="btn btn-primary">
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
            @endforeach
        </div>
    </div>
@endsection
