<template>
    <Head title="Log in" />

    <jet-authentication-card>

        <Link class="flex flex-col justify-center mt-2" :href="route('courses.index')">
            <div class="flex mx-auto">
                <img class="flex w-16 h-16 rounded-full" src="/images/theLogo.png" alt="">
            </div>
            <div class="font-bold flex flex-col justify-center text-center ml-3">
                <p class="italic">U.E.D Manuel Antonio Carreño</p>
                <p class="text-sm">Sistema de Gestión y Registro</p>
            </div>
        </Link>

        <jet-validation-errors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="flex flex-col text-center justify-between mt-8 mx-auto">
            <p>Login as Demo User: </p>
            <Link :href="loginAsDemoUrl" method="post" as="button" class="text-white font-black text-lg w-32 mx-auto mt-3 rounded-md py-2 px-4 bg-green-800 hover:bg-green-600">Demo</Link>
        </div>

        <p class="mt-8 text-center">Or</p>
        <div class="mt-3 mb-3 mx-auto w-8/12 border border-t border-gray-200"></div> 

        <form @submit.prevent="submit">
            <div>
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
            </div>

            <div class="mt-4">
                <jet-label for="password" value="Password" />
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="flex justify-between mt-4">
                <label class="flex items-center">
                    <jet-checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>

                <div class="flex items-center justify-end">
                    <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                        Forgot your password?
                    </Link>

                    <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log in
                    </jet-button>
                </div>    
            </div>

            <p class="mt-8 text-center">Or</p>
            <div class="mt-3 mb-3 mx-auto w-8/12 border border-t border-gray-200"></div> 
            <div class="flex justify-between mt-5 mx-auto">
                <Link :href="route('register')" class="underline text-sm text-gray-600 hover:text-gray-900">Don't have an account?</Link>
                <Link :href="route('register')" class="text-white rounded-md py-2 px-4 bg-gray-700 hover:bg-gray-600">Register</Link>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                }),
                loginAsDemoUrl: '/loginAsDemo'
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    })
</script>
