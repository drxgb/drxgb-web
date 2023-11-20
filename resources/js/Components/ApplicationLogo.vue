<script setup>
defineProps({
	classes: String
});
</script>

<template>
	<img src="/img/logo.png" alt="logo" :class="classes" />
</template>
