import { createApp } from 'vue';

const auth = createApp({});

// Authenticated components
import LoginComponent from './components/auth/LoginComponent.vue';
import RegisterComponent from './components/auth/RegisterComponent.vue';
import ForgotPasswordComponent from './components/auth/ForgotPasswordComponent.vue';
import ResetPasswordComponent from './components/auth/ResetPasswordComponent.vue';


auth.component('login-component', LoginComponent);
auth.component('register-component', RegisterComponent);
auth.component('forgot-password-component', ForgotPasswordComponent);
auth.component('reset-password-component', ResetPasswordComponent);

auth.mount('#auth');
