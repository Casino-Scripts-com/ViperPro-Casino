<template>
    <RouterView v-slot="{ Component, route }">
        <Transition name="page-opacity" mode="out-in">
            <div :key="route.name">
                <component :is="Component"></component>
            </div>
        </Transition>
    </RouterView>
</template>

<script>
import { onMounted } from "vue";
import { RouterView } from "vue-router";

export default {
    props: [],
    components: { RouterView },
    data() {
        return {

        }
    },
    setup(props) {
        onMounted(() => {
        });

        return {};
    },
    computed: {

    },
    mounted() {

    },
    methods: {

    },
    watch: {

    },
};
</script>

<style scoped>

</style>
