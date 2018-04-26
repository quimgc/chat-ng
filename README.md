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

Aquest canal s'ha de crear a **routes/channel.php**.


Com que és un canal public, s'ha de crear al fitxer **channels.php** un canal amb aquest nom.



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

Al component de l'element que se'l vol fer "get real", s'ha d'afegir el següent codi al mounted.

      Echo.channel('newMessage')
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
              return new Channel('newMessage');
      //        return new PrivateChannel('channel-name');
          }
      }
