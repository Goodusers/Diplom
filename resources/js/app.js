import './bootstrap';
import { createApp } from 'vue';
import ChatMessage from './components/ChatMessage.vue';
import ChatForm from './components/ChatForm.vue';
import MessageCommunity from './components/MessageCommunity.vue';
import FormCommunity from './components/FormCommunity.vue';

// Создание приложения Vue
const app = createApp({
  components: {
    ChatMessage,
    ChatForm,
    FormCommunity,
    MessageCommunity
  }
});

// Функция для безопасного получения атрибутов
const getAttributeSafe = (selector, attribute) => {
  const element = document.querySelector(selector);
  return element ? element.getAttribute(attribute) : null;
};

// Установка глобальных свойств
app.config.globalProperties.$friendId = getAttributeSafe('#links-chat', 'friend-user-id');
app.config.globalProperties.$chatId = getAttributeSafe('#image_chat_friend', 'chat-id');
app.config.globalProperties.$userId = getAttributeSafe('#data-user', 'data-user-id');
app.config.globalProperties.$title = getAttributeSafe('#title', 'title');
app.config.globalProperties.$user_id = getAttributeSafe('#settings_block', 'user-id');
app.config.globalProperties.$userName = getAttributeSafe('#user-name', 'user-name');

// Монтирование приложения
app.mount('#app');
