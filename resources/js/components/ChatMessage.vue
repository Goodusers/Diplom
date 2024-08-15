<template>
    <!-- Сообщения -->
    <div class="message-block-wrap">
        <div v-for="message in messages" :key="message.id" class="message-block">
            <div v-if="message.chat_id == $chatId">
    
                <div v-if="message.user_id == $userId" class="messages-all">
                    
                    <span>
                        {{ message.message }}
                        
                    </span>
                    <img v-if="message.image" :src="'../'+message.image" alt="Image" class="message-image">
                    <a v-if="message.file" :href="'../chat_files/'+message.file" :download="message.file" alt="File" class="message-image">{{ message.file }}</a>
                    <div class="date">
                        <small id="small_date">{{ twoFormatDate(message.created_at) }}</small>
                        <small id="small_date">{{ formatDate(message.created_at) }}</small>
                    </div>
                </div>
                <div v-else class="messages-else">
                    <span>{{ message.message }}</span>
                    <img v-if="message.image" :src="'../'+message.image" alt="Image" class="message-image">
                    <a v-if="message.file" :href="'../chat_files/'+message.file" :download="message.file" alt="File" class="message-image">{{ message.file }}</a>
                    <div class="date-t">
                        <small id="small_date">{{ twoFormatDate(message.created_at) }}</small>
                        <small id="small_date">{{ formatDate(message.created_at) }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
        }
    },
    mounted() {
        this.loadMessages();
        Echo.private('chat.' + this.$chatId)
            .listen('MessageSent', (event) => {
                console.log("получено новое сообщение:", event.message);
                if (Array.isArray(this.messages)) {
                    this.messages.push(event.message);
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });
                } else {
                    console.error('messages is not an array', this.messages);
                }
            })
            .subscribed(() => {
                console.log('Успешная подписка на приватный канал chat.2');
            })
            .error((error) => {
                console.error('Error subscribing to the channel:', error);
            });
    },
    methods: {
        loadMessages() {
            axios.get('/messages/' + this.$chatId)
                .then(response => {
                    this.messages = response.data;
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });
                })
                .catch(error => {
                    console.error('Error fetching messages:', error);
                });
        },
        formatDate(dateTime) {
            const date = new Date(dateTime);
            const options = {
                hour: '2-digit',
                minute: '2-digit',
                timeZone: 'Asia/Yekaterinburg' // Указываем часовой пояс города Уфа (UTC+5)
            };
            return new Intl.DateTimeFormat('ru-RU', options).format(date);
        },
        twoFormatDate(dateTime) {
            const date = new Date(dateTime);
            const options = {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                timeZone: 'Asia/Yekaterinburg' // Указываем часовой пояс города Уфа (UTC+5)
            };
            return new Intl.DateTimeFormat('ru-RU', options).format(date);
        },
        scrollToBottom() {
            const container = document.querySelector(".message-block-wrap");
            container.scrollTop = container.scrollHeight;
        }
    }
}
</script>

<style scoped>
.message-image {
    max-width: 100%;
    height: auto;
    margin-top: 10px;
}
small{
    display: flex;
    margin-top: 10px;
    margin-left: 10px;
}
.date{
    width: 100%;
    display: flex;
    justify-content: space-between;
}
.date-t{
    width: 100%;
    display: flex;
    margin-top: 10px;
}
.wrap-icon{
    display: flex;
}
.icon-edit{
    margin: 0 5px;
}
.icon-trash{
    margin: 0 5px;
    margin-right: 10px;
}
svg{
    stroke:#8DA399;
}
.icon-edit svg:hover{
    stroke:#CC397B;
    cursor: pointer;
}
.icon-trash svg:hover{
    stroke:#CC397B;
    cursor: pointer;
}
.messages-all{
    flex-direction: column;
}
</style>
