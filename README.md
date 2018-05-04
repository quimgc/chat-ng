# LARAVEL NOTIFICATION

http://laravel-notification-channels.com/

Es necessita un servei web push.

http://laravel-notification-channels.com/webpush/

Paquet guia: laravel-web-push-demo

Es segueix la teoria del link **webpush**.


# CHAT-NG AMB TEMPS REAL

El primer que he fet ha sigut entrar a pusher.com i crear una nova app per agafar les claus i posar-ho al .env.

També canviar aquest paràmetre del .env:

    BROADCAST_DRIVER=log
    
Per:

    BROADCAST_DRIVER=pusher
    
Descomentar linia de **config/app.php**:

    App\Providers\BroadcastServiceProvider::class,

Instal·lar composer pusher:

    $ composer require pusher/pusher-php-server

Un cop fet tot això s'ha de crear un esdevniment.

    php artisan make:event newMessage
    
    
 Al esdevniment generat, se li ha d'implementar **ShouldBroadcast**.
 
    Class newMessage implements ShouldBroadcast
    

A la classe a la funció **broadcastOn** se li ha de canviar el return per un amb el **Channel** public:

    return new Channel('nom canal');

Aquest canal s'ha de crear a **routes/channel.php**. He creat un canal amb el següent contingut:

    Broadcast::channel('Chat.{chat}.newMessage', function ($chat, $user) {
        return true;
    });
    
D'aquesta forma m'asseguro de que cada missatge va dirigit al xat corresponent i no a tots.


# Configuració del Laravel Echo

Instal·lar amb npm:

    npm install laravel-echo pusher-js

Al fitxer **bootstrap.js** s'ha d'afegfir les següents linies:

    import Echo from 'laravel-echo'
    
    window.Pusher = require('pusher-js');
    
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: process.env.MIX_PUSHER_APP_KEY,
        cluster: process.env.MIX_PUSHER_APP_CLUSTER,
        encrypted: true
    });


Si la pàgina dóna algun error de **csrf token** s'ha d'afegir: 

    <meta name="csrf-token" content="{{ csrf_token() }}">

Al component de l'element que se'l vol fer "real time", s'ha d'afegir el següent codi al mounted.

      Echo.channel('Chat.' + this.chat.id + '.newMessage')
            .listen('newMessage', e => {
              console.log('New Message has been updated.')
            })
            
El que s'està fent és dirli quin channel ha d'escoltar i on posa .listen és l'esdevniment que s'executa.


Tot seguit des del controlador que es vulgui executar, se li ha de passar la informació a l'event de la següent forma:

    class ChatMessageController extends Controller
    {
        /**
         * Create chat message
         */
        public function create(Request $request, Chat $chat)
        {
    //        newMessage::dispatch();
            Log::info('send sms');
    
            $message = $request->body;
    
            event(new newMessage($message, $chat));
    
            $chat->addMessage($message);
    
    
    
            //TODO notifications al web push
        }
    }

    
$message i $chat són dos variables del mateix controlador per passar el missatge de xat i la info del xat. Aquestes variables s'han de dir exactament igual a l'event.


Exemple de event:


      class newMessage implements ShouldBroadcast
      {
          use Dispatchable, InteractsWithSockets, SerializesModels;
      
          public $message;
      
          public $chat;
      
          /**
           * Create a new event instance.
           *
           * @return void
           */
          public function __construct($message, $chat)
          {
              $this->message = $message;
      
              $this->chat = $chat;
          }
      
          /**
           * Get the channels the event should broadcast on.
           *
           * @return \Illuminate\Broadcasting\Channel|array
           */
          public function broadcastOn()
          {
              return new Channel('Chat.' + this.chat.id + '.newMessage');
      //        return new PrivateChannel('channel-name');
          }
      }


Per arreglar "l'error" de que a la finestra que enviem el missatge aparegui dos cops, s'ha de fer el següent.

Al controlador que s'envia l'esdeveniment s'ha de posar el -> **dontBroadcastToCurrentUser()**.

     event(
                (new newMessage($message, $chat))->dontBroadcastToCurrentUser()
     );
     
Per últim, al component ChatComponent he afegit el següent mètode:

     startEcho() {
            Echo.channel('Chat.' + this.chat.id + '.newMessage')
              .listen('newMessage', e => {
                const message = {
                  'body':  e.message,
                  'chat_id': e.chat.id,
                  'formatted_created_at_date': this.timestamp(),
                  user: {
                    'name': this.logged_user.name,
                    'avatar': this.logged_user.avatar,
                    'id': this.logged_user.id
                  }
                }
                this.chat.messages.push(message)
                this.scroll_top_down()
              })
          }
          
          
Al mounted he afegit **this.startEcho()**.


# PDF

-> dompdf canvia de html a php.

https://github.com/dompdf/dompdf

Amb l'ajuda d'aquest paquet ho utilitzem amb laravel i ens crea una facade.

https://github.com/barryvdh/laravel-dompdf

