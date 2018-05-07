<template>

    <li class="dropdown messages-menu">
        <!-- Menu toggle button -->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="label label-success">4</span>
        </a>
        <ul class="dropdown-menu">
            <!--<li class="header">{{ trans('adminlte_lang::message.tabmessages') }}</li>-->
            <li class="header">Tens 4 missatges per llegir...</li>
            <li>

                <ul class="menu">
                    <li v-for="message in internalMessages">
                        <a href="#">
                            <div class="pull-left">

                                <!--<img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image"/>-->
                                <img src="/img/photo1.png" class="img-circle" alt="User Image"/>
                            </div>
                            <h4>
                                {{message.user}}
                                <!--{{ trans('adminlte_lang::message.supteam') }}-->
                                Prova no se que es
                                <small><i class="fa fa-clock-o"></i>{{ message.created_at }}</small>
                            </h4>
                            <!--<p>{{ trans('adminlte_lang::message.awesometheme') }}</p>-->
                            <p>{{ message.text }}</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="footer"><a href="#">c</a></li>
        </ul>
    </li>

</template>

<style>

</style>

<script>
export default {
  data () {
    return {
      internalMessages: this.messages
//      internalMessages: [
//        {
//          user: 'Pepito',
//          text: 'Hola',
//          created_at: '1 minute ago'
//        },
//        {
//          user: 'Quim',
//          text: 'Adeu',
//          created_at: '2 minute ago'
//        },
//        {
//          user: 'Quim2',
//          text: 'Hola i Adeu',
//          created_at: '4 minute ago'
//        }
//      ]
    }
  },
  props: {
    messages: {
      type: Array,
      required: true
    }
  },
  mounted () {
    console.log('Mounted ok')
  }
}
</script>