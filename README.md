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