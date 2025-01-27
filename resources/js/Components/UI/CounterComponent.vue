<template>
    <div class="flex">
        <button @click="decrement" :disabled="count <= 0"><i class="fa-solid fa-minus"></i></button>
        <span class="px-4">{{ count }}</span>
        <button @click="increment" :disabled="count >= maxCount"><i class="fa-solid fa-plus"></i></button>
    </div>
</template>

<script>
export default {
    props: {
        initialCount: {
            type: Number,
            default: 0
        },
        maxCount: {
            type: Number,
            default: Infinity
        }
    },
    data() {
        return {
            count: this.initialCount
        };
    },
    methods: {
        increment() {
            if (this.count < this.maxCount) {
                this.count++;
            }
        },
        decrement() {
            if (this.count > 0) {
                this.count--;
            }
        }
    },
    watch: {
        count(newCount) {
            this.$emit("count-changed", newCount);
        }
    }
};
</script>
