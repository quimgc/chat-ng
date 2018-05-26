<template>
    <!--v-if="this.seeUnreadMessages"-->
    <li  class="dropdown messages-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="label label-success">{{this.missatgesNollegits.length}}</span>
        </a>
        <ul class="dropdown-menu">
            <li class="header">Tens {{this.missatgesNollegits.length}} missatges per llegir...</li>
            <li>
                <ul class="menu">
                    <li v-for="message in missatgesNollegits" @click="readNotification(message)">
                        <a href="#">
                            <div class="pull-left">
                                <img src="/img/photo1.png" class="img-circle" alt="User Image"/>

                            </div>
                            <h4>
                                <p>{{ message.user }}</p>

                                <!--<small><i class="fa fa-clock-o"></i>{{ message.created_at }}</small>-->
                            </h4>
                            <p>{{ message.chat }}</p>
                        </a>
                    </li>
                </ul>
            </li>
            <!--<li class="footer" @click="mostrarTotes()"><a href="#">Veure totes</a></li>-->
            <!--<li class="footer" @click="llegirTotes()"><a href="#">Llegir totes</a></li>-->
        </ul>
    </li>
    <!--<li v-else="this.seeUnreadMessages" class="dropdown messages-menu">-->
        <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
            <!--<i class="fa fa-envelope-o"></i>-->
            <!--<span class="label label-success">{{this.totalMessages.length}}</span>-->
        <!--</a>-->
        <!--<ul class="dropdown-menu">-->
            <!--<li class="header">Tens {{this.totalMessages.length}} missatges de xat pendents</li>-->
            <!--<li>-->
                <!--<ul class="menu">-->
                    <!--<li v-for="message in totalMessages" @click="readNotification(message)">-->
                        <!--<a href="#">-->
                            <!--<div class="pull-left">-->
                                <!--<img src="/img/photo1.png" class="img-circle" alt="User Image"/>-->
                            <!--</div>-->
                            <!--<h4>-->
                                <!--{{ message.user}}-->
                                <!--<small><i class="fa fa-clock-o"></i>{{ message.created_at }}</small>-->
                            <!--</h4>-->
                            <!--<p>{{ message.text }}</p>-->
                        <!--</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</li>-->
            <!--<li v-if="!this.seeUnreadMessages" class="footer" @click="mostrarNoLlegides()"><a href="#">Veure No Llegides</a></li>-->
            <!--<li class="footer" @click="llegirTotes()"><a href="#">Llegir totes</a></li>-->
        <!--</ul>-->
    <!--</li>-->
</template>

<style>

</style>

<script>
  var moment = require('moment');
  import axios from 'axios'
  export default {
    data() {
      return {
        missatgesNollegits: [],
        totalMessages: [],
        seeUnreadMessages: true,
      }
    },
    props: {
      messages: {
        type: Array,
        required: true
      },
      user: {
        required: true
      }
    },
    methods: {
      moment: function () {
        return moment();
      },
      mostrarNoLlegides(){
        this.seeUnreadMessages = true;
      },
      mostrarTotes(){
        this.seeUnreadMessages = false;
      },
      llegirTotes() {
        this.messages.forEach((notification) => {
          axios.post(`/notifications/read/${notification.id}`)
        })
        this.missatgesNollegits = []
      },
      readNotification(missatge) {
        var readNotification = this.messages.find((notification) => {
          if (missatge==notification){
            return notification
          }
        })
        var index = this.missatgesNollegits.indexOf(missatge)
        console.log(readNotification)
        axios.post(`/notifications/read/${readNotification.id}`)
          .then(
            this.missatgesNollegits.splice(index, 1)
          )
      },
      timestamp() {
        return moment().format('YYYY-MM-DD hh:mm:ss')
      },
      getUnreadNotifications() {
        console.log(this.messages)
        this.missatgesNollegits = this.messages
      },
      startListener() {
        Echo.private(`App.User.${this.user.id}`)
          .notification((notification) => {
            const message = {
              'chat': notification.chat,
              'text': notification.message,
              'user': notification.user,
              'id': notification.id,
              created_at: {
                'date': this.timestamp(),
                'timezone': "UTC",
                'timezone_type': 3
              }
            }
            console.log('pujar sms')
            console.log(message)
            this.missatgesNollegits.push(message)
          })
      },
    },
    mounted() {
      this.getUnreadNotifications()
      this.startListener()
    }
  }
</script>