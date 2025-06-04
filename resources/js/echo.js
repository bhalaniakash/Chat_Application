import Echo from 'laravel-echo';
import { io } from 'laravel-echo/dist/socket.io';

window.io = io;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: '',
    host: window.location.hostname + ':8080', 
    authEndpoint: '/broadcasting/auth',
    transports: ['websocket'],
    forceTLS: false,
    encrypted: false,
});
