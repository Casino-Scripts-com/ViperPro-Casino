<template>
    <div v-if="!cookieAccepted" class="flex justify-between items-center fixed left-0 md:left-10 bottom-10 z-[999] p-4 dark:bg-gray-900 shadow-lg">
        <p>Usamos cookies para fornecer a melhor experiência para você.</p>
        <button @click="acceptCookie" class="ui-button-blue ml-3">Aceitar</button>
    </div>
</template>

<script>
    export default {
        props: {

        },
        data() {
            return {
                cookieAccepted: localStorage.getItem('cookieAccepted') === 'true',
            };
        },
        methods: {
            acceptCookie() {
                localStorage.setItem('cookieAccepted', 'true');
                this.cookieAccepted = true;
            },
        },
        watch: {

        }
    };
</script>
