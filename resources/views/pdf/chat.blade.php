<div>
    <h1>{{ $chat->name }}</h1>
    <div class="direct-chat-messages">
        @foreach($chat->messages as $message)
            <div class="message">
                <div class="message-content">
                    <div>
                        <span class="user_name">{{ $message->user->name }}</span>
                        <div class="data">
                            <span> {{ $message->formatted_created_at_date }}</span>
                        </div>
                    </div>
                    <div>
                        {{ $message->body }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    div {
        font-family: Arial, Helvetica, sans-serif;
    }
    h1 {
        text-align: left;
    }

    .data {
        text-align: right;
    }

    .user_name {
        font-weight: bold;
        font-size: 15px;
    }

    .message {
        background-color: #cbcaaf;
        margin-bottom: 25px;

    }

    .message-content {
        display: inline-block;
        padding-left: 20px;
    }
</style>

{{--<div>--}}
{{--<img src="/public/{{ $message->user->avatar }}" alt="avatar">--}}
{{--<p>{{ $message->user->name }}</p>--}}
{{--<p>{{ $message->body }}</p>--}}
{{--</div>--}}
