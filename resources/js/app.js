import './bootstrap';
import { createApp } from 'vue';
import NoteForm from './components/NoteForm.vue';

const app = createApp({});

app.component('note-form', NoteForm);

app.mount('#app');

