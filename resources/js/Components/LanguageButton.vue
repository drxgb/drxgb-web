<script setup lang="ts">
import PrimaryButton from './PrimaryButton.vue';
</script>


<template>
	<PrimaryButton icon="globe">
		<img :src="`/img/flags/us.gif`" alt="us" />
		<span class="mx-2">English (US)</span>
		<font-awesome-icon :icon="['fas', 'angle-right']" />
	</PrimaryButton>
</template>
