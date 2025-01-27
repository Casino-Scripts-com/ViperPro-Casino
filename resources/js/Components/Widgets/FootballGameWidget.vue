<template>
    <div :id="containerId"
         :data-host="host"
         :data-key="apiKey"
         :data-id="gameId"
         :data-theme="theme"
         :data-refresh="refresh"
         :data-show-errors="showErrors"
         :data-show-logos="showLogos">
    </div>
</template>

<script>
export default {
    props: {
        gameId: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            containerId: 'wg-api-football-game',
            host: 'v3.football.api-sports.io',
            apiKey: '',
            theme: '',
            refresh: 15,
            showErrors: false,
            showLogos: true
        };
    },
    mounted() {
        const script = document.createElement('script');
        script.type = 'module';
        script.src = 'https://widgets.api-sports.io/2.0.3/widgets.js';
        this.$el.appendChild(script);
    }
};
</script>
