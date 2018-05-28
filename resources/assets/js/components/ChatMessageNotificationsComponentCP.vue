<template>

    <li class="dropdown messages-menu">
        <!-- Menu toggle button -->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="label label-success">{{ this.missatgesNollegits.length }}</span>
        </a>
        <ul class="dropdown-menu">
            <!--<li class="header">{{ trans('adminlte_lang::message.tabmessages') }}</li>-->
            <li class="header">Tens {{this.missatgesNollegits.length}} missatges per llegir...</li>
            <li>

                <ul class="menu">
                    <li v-for="message in this.missatgesNollegits" @click="readNotification(message)">
                        <a href="#">
                            <div class="pull-left">

                                <!--<img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image"/>-->
                                <img src="/img/photo1.png" class="img-circle" alt="User Image"/>
                            </div>
                            <h4>
                                {{message.user}}
                                <!--{{ trans('adminlte_lang::message.supteam') }}-->
                                <small><i class="fa fa-clock-o"></i>{{ message.created_at }}</small>
                            </h4>
                            <!--<p>{{ trans('adminlte_lang::message.awesometheme') }}</p>-->
                            <p>{{ message.text }}</p>
                        </a>
                    </li>
                </ul>
            </li>
            <!--<li class="footer"><a href="#">c</a></li>-->
        </ul>
    </li>

</template>

<style>

</style>

<script>
  import moment from 'moment'
  export default {
  data () {
    return {
      internalMessages: this.messages,
      missatgesNollegits: []
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
    readNotification(sms) {
      console.log(sms)
        var readNotification = this.messages.find((notification) => {
            if (sms == notification){
              return notification
            }
        })
        var index = this.missatgesNollegits.indexOf(sms)
      console.log(index)
      console.log(readNotification)
        axios.post(`/notifications/read/${readNotification.id}`)
            .then(
            this.missatgesNollegits.splice(index, 1)
        )
      this.missatgesNollegits.splice(index, 1)

    },
    timestamp() {
      return moment().format('YYYY-MM-DD hh:mm:ss')
    },
    getUnreadSMS() {
      this.missatgesNollegits = []
        this.messages.forEach((sms => {
          if(sms.read_at == null) {
            this.missatgesNollegits.push(sms)
          }
        }))
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
            this.missatgesNollegits.push(message)
          })
    },
  },
  mounted () {
    this.getUnreadSMS()
    this.startListener()
  }
}
</script>