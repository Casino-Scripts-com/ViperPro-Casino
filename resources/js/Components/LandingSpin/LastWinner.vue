<template>
    <div class="data-cont">
	    <img class="avatar " :src="'/assets/images/spin/avatar.png'">
		<div class="cont">
			<div class="name">{{winner.name}}</div>
			<div class="win">Win: <span class="amount">{{ winner.prize }}</span> <span class="currency text-uppercase">{{ winner.currency }}</span> </div>
		</div>
	</div>
</template>

<script setup>
    defineProps({
        winner: Object
    });
</script>

<style scoped>
    .data-cont {
        position: relative;
        height: 92px;
        top:0px;
        right: 0px;
        transform-origin: bottom center;
        transform-style: preserve-3d;
    }
    .data-cont > .avatar {
        position: absolute;
        top: .9375rem;
        width: 1.75rem;
        height: 1.75rem;
        border-radius: 50%;
        left: 1rem
    }
</style>
