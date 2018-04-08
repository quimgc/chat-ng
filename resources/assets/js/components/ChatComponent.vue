<template>
    <div class="box box-warning direct-chat direct-chat-warning">
        <div class="box-header with-border">
            <h3 class="box-title">{{ chat.name }}</h3>

            <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="" class="badge bg-yellow" data-original-title="3 New Messages">3</span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts">
                    <i class="fa fa-comments"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="direct-chat-messages" ref="chat">
                <div class="direct-chat-msg" :class="{ right: own(message) }"v-for="message in internalMessages">
                    <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">{{ message.user.name }}</span>
                        <span class="direct-chat-timestamp pull-right"> {{ message.formatted_created_at_date }}</span>
                    </div>
                    <img class="direct-chat-img" :src="message.user.avatar" alt="message user image">
                    <div class="direct-chat-text">
                        {{ message.body }}
                    </div>
                </div>
            </div>

            <div class="direct-chat-contacts">
                <ul class="contacts-list">
                    <li v-for="participant in participants">
                        <a href="#">
                            <img class="contacts-list-img" :src="participant.avatar" alt="User Image">

                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  {{ participant.name }}
                                  <small class="contacts-list-date pull-right">{{ participant.created_at }}</small>
                                </span>
                                <span class="contacts-list-msg">TODO...</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="box-footer">
            <div class="input-group">
                <input type="text" name="message" placeholder="Type Message ..." class="form-control" v-model="message" @keyup.enter.prevent="send">
                <span class="input-group-btn">
                        <button type="button" class="btn btn-warning btn-flat" @click.prevent="send" >Send</button>
                      </span>
            </div>
        </div>
    </div>
</template>

<script>
  import moment from 'moment'

  export default {
    data() {
      return {
        internalMessages: this.chat.messages,
        participants: [],
        message:'',
        logged_user: JSON.parse(window.user)
      }
    },
    props: {
      chat: {
        type: Object,
        required: true
      }
    },
    methods: {
      own(message) {
        return message.user.id === this.logged_user.id
      },
      send() {
        axios.post('/chat/' + this.chat.id + '/message', {
          'body': this.message
        }).then(response => {
          const message = {
            'body':  this.message,
            'chat_id': this.chat.id,
            'formatted_created_at_date': this.timestamp(),
            user: {
              'name': this.logged_user.name,
              'avatar': this.logged_user.avatar,
              'id': this.logged_user.id
            }
          }
          console.log('MESSAGE:')
          console.log(message)
          this.internalMessages.push(message)
        }).catch(error => {
          console.log('Error')
          console.log(error)
        }).then(() => {
          this.scroll_top_down()
          this.message = ''
        })
      },
      scroll_top_down() {
        this.$refs.chat.scrollTop = this.$refs.chat.scrollHeight;
      },
      timestamp() {
        return moment().format('YYYY-MM-DD hh:mm:ss')
      }
    },
    mounted() {
      this.scroll_top_down()
    }
  }
</script>
