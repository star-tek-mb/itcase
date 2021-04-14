<template>
    <div class="content-chat">
        <div class="list" v-chat-scroll style="max-height: 500px; overflow-y: scroll">
            <div class="chat-item" v-bind:class="{ gray: user.id === message.user.id, green: companion.id === message.user.id }" v-for="message in messages" :key="message.id">
                <div class="avatar">
                    <img v-if="user.image === null" :src="getUserImage(message.user)" :alt="getUserName(message.user)">
                </div>
                <div class="text">
                    <div class="name">{{ getUserName(message.user) }}</div>
                    <div class="time">{{ formatDate(message.created_at) }}</div>
                    <div class="content">{{ message.text }}</div>
                </div>
            </div>
        </div>
        <div class="send-message">
            <div class="inner">
                <input type="text" class="form-control" v-model="newMessage" @keyup.enter="sendMessage" placeholder="Введите сообщение...">
                <button class="btn btn-light-green" v-on:click="sendMessage"><i class="fas fa-paper-plane"></i> <span>Отправить</span></button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                messages: [],
                newMessage: ''
            }
        },
        props: ['chatId', 'companion', 'user'],
        created() {
            this.fetchMessages();
            setInterval(this.fetchUnreadMessages, 1500);
        },
        methods: {
            fetchMessages() {
                axios.get(`/site/messages?chat_id=${this.chatId}`).then(response => {
                    this.messages = response.data;
                });
            },
            sendMessage() {
                axios.post('/site/messages', { 'chatId': this.chatId, 'message': this.newMessage }).then(response => {
                    this.messages.push(response.data);
                    this.newMessage = '';
                });
            },
            fetchUnreadMessages() {
                axios.get(`/site/messages?chat_id=${this.chatId}&unread_only`).then(response => {
                    this.messages = this.messages.concat(response.data);
                });
            },
            formatDate(dateString) {
                let date = new Date(dateString);
                let hours = date.getHours();
                let minutes = date.getMinutes();
                return `${hours}:${minutes}`;
            },
            getUserImage(user) {
                if (this.user.contractor_type && user.customer_type) {
                    return '/assets/img/avatars/avatar15.jpg';
                } else {
                    if (user.image !== null)
                        return `/uploads/users/${user.image}`;
                    return '/assets/img/avatars/avatar15.jpg';
                }

            },
            getUserName(user) {
                if (this.user.contractor_type && user.customer_type) {
                    return 'Заказчик';
                } else {
                    return user.company_name ? user.company_name : user.name;
                }
            }
        }
    }
</script>
