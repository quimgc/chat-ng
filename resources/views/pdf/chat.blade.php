<h1> {{ $chat->name }}</h1>



<ul>
    <?php foreach($chat->messages as $message): ?>
        <div>
            <b>{{$message->user->name}}</b>: {{$message->body}} <br>
        </div>
    <?php endforeach; ?>
</ul>

<style>
    div{
        padding: 10px;
    }
    div:nth-child(odd) { background: #ddd }
</style>