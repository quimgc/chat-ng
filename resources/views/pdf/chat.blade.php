<h1> {{ $chat->name }}</h1>



<ul>
    <?php foreach($chat->messages as $message): ?>
        <div>
            <b>{{$message->user->name}}</b>: {{$message->body}} <div id="date">{{$message->formatted_created_at_date}}</div><br>
        </div>
    <?php endforeach; ?>
</ul>

<style>
    div{
        display: flex;
        padding: 10px;
    }

    div:nth-child(odd) { background: #ddd }

    #date{
        padding: 0px;
        margin-left: auto;
        color: grey;
        font-size: 12px;
    }
</style>