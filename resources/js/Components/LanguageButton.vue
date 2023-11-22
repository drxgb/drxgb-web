<script setup lang="ts">
import Button from './Button.vue';

defineProps({
	color: {
		type: String,
		default: 'primary'
	}
});
</script>


<template>
	<Button :color="color">
		<span class="flex items-baseline">
			<img :src="`/img/flags/us.gif`" alt="us" />
			<span class="mx-2">English (US)</span>
			<font-awesome-icon :icon="['fas', 'angle-right']" />
		</span>
	</Button>
</template>
