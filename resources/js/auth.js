import { createApp } from 'vue';

const auth = createApp({});

// Authenticated components
import ForgotPasswordComponent from './components/auth/ForgotPasswordComponent.vue';
import ResetPasswordComponent from './components/auth/ResetPasswordComponent.vue';

auth.component('forgot-password-component', ForgotPasswordComponent);
auth.component('reset-password-component', ResetPasswordComponent);

auth.mount('#auth');
