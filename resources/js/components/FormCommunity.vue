<template>
    <div class="wrap-info">
      <div class="info">
        <div v-if="isTyping" class="typing-indicator"> печатает...</div>
      </div>
      <div class="wrap-input">
        <div class="message-input">
          <div class="paper">
            <svg fill="#000000" width="30px" height="30px" viewBox="0 0 35 35" version="1.1" xmlns="http://www.w3.org/2000/svg">
              <path d="M5.397 31.488c-1.356 0-2.659-0.561-3.697-1.6-2.301-2.309-2.301-6.064-0.001-8.372l17.946-19.057c2.8-2.804 7.089-2.553 10.219 0.582 1.402 1.405 2.189 3.431 2.16 5.559-0.029 2.107-0.852 4.123-2.259 5.531l-13.563 14.439c-0.377 0.404-1.011 0.423-1.413 0.044s-0.421-1.014-0.043-1.417l13.584-14.461c1.063-1.065 1.672-2.575 1.695-4.164s-0.552-3.090-1.574-4.114c-1.92-1.924-5.046-2.932-7.37-0.602l-17.945 19.057c-1.543 1.547-1.542 4.032-0.020 5.558 0.714 0.715 1.562 1.063 2.464 1.008 0.893-0.055 1.811-0.512 2.585-1.288l14.279-15.198c0.517-0.518 1.558-1.79 0.499-2.851-0.599-0.601-1.020-0.563-1.159-0.552-0.395 0.035-0.858 0.309-1.337 0.79l-10.748 11.43c-0.38 0.404-1.013 0.423-1.414 0.043-0.402-0.379-0.421-1.014-0.042-1.416l10.767-11.452c0.846-0.851 1.712-1.312 2.593-1.391 0.688-0.061 1.71 0.085 2.753 1.131 1.548 1.551 1.355 3.826-0.477 5.663l-14.279 15.197c-1.14 1.144-2.517 1.808-3.898 1.893-0.101 0.007-0.203 0.010-0.304 0.010z"></path>
            </svg>
            <div class="paper-block">
              <div class="download-photo">
                <span @click="triggerClickPhoto">загрузить фото</span>
              </div>
              <div class="download-file">
                <span @click="triggerClickFile">загрузить файл</span>
              </div>
            </div>
          </div>
          <textarea v-model="newMessage" @input="updateTyping" @keyup.enter="sendMessage" placeholder="введите ваше сообщение..."></textarea>
          <input type="file" id="photoInput" style="display:none;" @change="handlePhotoUpload" accept="image/*"> 
          <input type="file" id="fileInput" style="display:none;" @change="handleFileUpload" > 
          <button @click="sendMessage">{{click}} </button>
        </div>
      </div>
      <div class="info">
        <div class="error-message" v-if="errors">{{ errors }}</div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        newMessage: '',
        errors: '',
        isTyping: false,
        typingTimer: null, 
        messages: [],
        file: null,
        file2: null,
        click: 'отправить'
      };
    },
    mounted() {
      Echo.private('community_page.' + this.$title)
        .listen('CommunityMessageSent', (event) => {
          this.messages.push(event.message);
          this.isTyping = false;
        })
        .listenForWhisper('typing', (e) => {
          this.isTyping = e.typing;
          clearTimeout(this.typingTimer);
          if (e.typing) {
            this.typingTimer = setTimeout(() => {
              this.isTyping = false;
            }, 10000); // Скрыть индикатор через 2 секунды бездействия
          }
        })
        .subscribed(() => {
          console.log('Успешная подписка на канал');
        })
        .error((error) => {
          console.error('Ошибка подписки на канал:', error);
        });
    },
    methods: {
      handlePhotoUpload(event) {
        this.file = event.target.files[0];
      },
      handleFileUpload(event) {
        this.file2 = event.target.files[0];
      },
      sendMessage() {
        if (this.newMessage.trim() === '' && !this.file && !this.file2) {
          this.errors = 'сообщение не может быть пустым';
          return;
        }
  
        let formData = new FormData();
        formData.append('user_id', this.$user_id);
        formData.append('title', this.$title);
        formData.append('message', this.newMessage);
        if (this.file) {
          formData.append('image', this.file);
        }
        if (this.file2) {
          formData.append('file', this.file2);
        }
  
        axios.post('/send_community', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(response => {
          this.newMessage = '';
          this.file = null;
          this.file2 = null;
          this.errors = '';
        }).catch(error => {
          this.errors = 'ошибка отправки сообщения: ' + error.response.data.message;
        });
      },
      updateTyping() {
        clearTimeout(this.typingTimer);
        this.typingTimer = setTimeout(() => {
          Echo.private('community_page.' + this.$title).whisper('typing', { typing: false });
        }, 2000);
        Echo.private('community_page.' + this.$title).whisper('typing', { typing: true });
      },
      triggerClickPhoto(){
        document.getElementById('photoInput').click();
      },
      triggerClickFile(){
        document.getElementById('fileInput').click();
      }
      
    }
  }
  </script>
  
  <style scoped>
  .wrap-info{
    width: 100%;
    display: flex;
    flex-direction:column;
    align-items:center;
  }
  .info{
    width: 90%;
  }
  .wrap-input {
    width: 100%;
    display: flex;
    justify-content: center;
  }
  .message-input {
    width: 90%;
    display: flex;
    margin: 20px 0;
  }
  textarea {
    flex: 1;
    resize: none;
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    outline: none;
    flex-shrink: 0;
  }
  button {
    flex-shrink: 0;
    margin-left: 10px;
    padding: 5px 10px;
    border-radius: 5px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
  }
  button:hover {
    background-color: #45a049;
  }
  .error-message {
    color: red;
    margin-bottom: 20px;
  }
  .typing-indicator {
    color: green;
  }
  .error-message, .typing-indicator{
    font-family: 'RobotoCondensed-Italic-VariableFont_wght';
    font-size: 16px;
    font-weight: 400;
    letter-spacing: 0.1em;
  }
  </style>
  
  