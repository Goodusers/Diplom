<template>
    <!-- Сообщения -->
    <div class="message-block-wrap">
        <div v-for="message in messages" :key="message.id" class="message-block">
                <div v-if="message.user_id == $user_id" class="messages-all">
                    <span>{{ message.message }}</span>
                    <img v-if="message.image" :src="'../'+message.image" alt="Image" class="message-image">
                    <a v-if="message.file" :href="'../chat_files/'+message.file" :download="message.file" alt="File" class="message-image">{{ message.file }}</a>
                    <div class="date">
                        <small id="small_date">{{ twoFormatDate(message.created_at) }}</small>
                        <small id="small_date">{{ formatDate(message.created_at) }}</small>
                    </div>
                </div>
                <div v-else class="message-wrapping-else">
                    <div class="message_photo_user">
                        <img :src="'../image/userimage/' + message.user_photo" alt="userImage">
                    </div>
                    <div class="messages-else">
                        <div class="message_information">
                            <small id="small_name">{{ message.username }}</small>
                            <small id="small_date">{{ formatDate(message.created_at) }}</small>
                            <small id="small_date">{{ twoFormatDate(message.created_at) }}</small>
                        </div>
                        <span>{{ message.message }}</span>
                        <img v-if="message.image" :src="'../'+message.image" alt="Image" class="message-image">
                        <a v-if="message.file" :href="'../chat_files/'+message.file" :download="message.file" alt="File" class="message-image">{{ message.file }}</a>
                    </div>
                </div>

        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: []
        }
    },
    mounted() {
        this.loadMessages();
        Echo.private('community_page.' + this.$title)
            .listen('CommunityMessageSent', (event) => {
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
                console.log('Успешная подписка на приватный канал');
            })
            .error((error) => {
                console.error('Error subscribing to the channel:', error);
            });
    },
    methods: {
        loadMessages() {
            axios.get('/messages_community/' + this.$title)
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
#small_name{
    margin-bottom: 10px;
    margin-top: 0;
}
.messages-else{
    display: flex;
    flex-direction: column;
}
small{
    display: flex;
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
.date{
    width: 100%;
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
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
.message_photo_user{
    margin-left: 10px;
    border-radius: 50%;
    overflow: hidden;
    height: 40px;
    margin-bottom: 7px;
}
#small_date{
    margin-left: 20px;
}
.message_photo_user img{
    width: 40px;
    height: 40px;
}
.message-wrapping-else{
    display: flex;
    align-items: flex-end;
}
.message_information{
    display: flex;
}
.messages-all{
    flex-direction: column;
}
</style>
