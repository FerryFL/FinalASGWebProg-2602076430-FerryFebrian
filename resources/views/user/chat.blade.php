@extends('layout.master')
@section('title', 'Chat with ' . $friends->name)
@section('content')
    <div class="container mt-5">
        <h3 class="text-center mb-4">@lang('lang.chat_with', ['name' => $friends->name])</h3>

        <div class="chat-box" style="height: 400px; overflow-y: scroll; border: 1px solid #ddd; padding: 10px;">
            @foreach ($messages as $message)
                <div class="@if ($message->user_id === Auth::id()) text-end @else text-start @endif mb-3">
                    <div class="@if ($message->user_id === Auth::id()) bg-info text-white @else bg-light text-dark @endif p-2 rounded"
                        style="display: inline-block; max-width: 70%;">
                        <p class="mb-1">{{ $message->message }}</p>
                        <small class="d-block text-muted">
                            @if ($message->user_id === Auth::id())
                                @lang('lang.you')
                            @else
                                {{ $message->sender->name }}
                            @endif
                            - {{ $message->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
            @endforeach
        </div>

        <form action="{{ route('sendMessage') }}" method="POST" class="mt-3">
            @csrf
            <input type="hidden" name="chatroom_id" value="{{ $chatroom->id }}">
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="@lang('lang.type_your_message')" required>
                <button class="btn btn-primary" type="submit">@lang('lang.send')</button>
            </div>
        </form>
    </div>
@endsection
