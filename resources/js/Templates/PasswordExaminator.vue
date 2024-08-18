<script setup lang="ts">
import { computed } from 'vue';
import { PasswordMeter } from '@/Classes/Security/PasswordMeter';

const props = defineProps<{
	value: string,
}>();

const meter: PasswordMeter = new PasswordMeter;
const strength: any = computed<number>(() => (meter.check(props.value) / 300) * 100);
const message: any = computed<string>(() => {
	const s = strength.value;

	if (s === 0)	return 'no_password';
	if (s <= 16)	return 'very_weak';
	if (s <= 33)	return 'weak';
	if (s <= 66)	return 'medium';
	if (s <= 84)	return 'strong';

	return 'very_strong';
});
</script>


<template>
	<div class="flex flex-col gap-2 items-center">
		<div v-if="strength <= 33"
			class="w-full h-2 flex gap-0.5 overflow-hidden rounded-md bg-red-400"
		>
			<div class="h-2 bg-red-700" :style="`width: ${strength}%`" />
		</div>
		<div v-else-if="strength <= 66"
			class="w-full h-2 flex gap-0.5 overflow-hidden rounded-md bg-yellow-100"
		>
			<div class="h-2 bg-yellow-400" :style="`width: ${strength}%`" />
		</div>
		<div v-else
			class="w-full h-2 flex gap-0.5 overflow-hidden rounded-md bg-green-300"
		>
			<div class="h-2 bg-green-500" :style="`width: ${strength}%`" />
		</div>
		<span>
			{{ $t(`passwords.${message}`) }}
		</span>
	</div>
</template>
