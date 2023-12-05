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

	if (s === 0)
		return 'no_password';
	if (s <= 16)
		return 'very_weak';
	if (s <= 33)
		return 'weak';
	if (s <= 66)
		return 'medium';
	if (s <= 84)
		return 'strong';

	return 'very_strong';
});

function getBarColor(strength: number, background: boolean = false): string {
	let color;
	let intensity;

	if (strength <= 33) {
		color = 'red';
		intensity = background ? 400 : 700;
	} else if (strength <= 66) {
		color = 'yellow';
		intensity = background ? 100 : 400;
	} else {
		color = 'green';
		intensity = background ? 300 : 500;
	}

	return `bg-${color}-${intensity}`;
}
</script>


<template>
	<div class="flex flex-col gap-2 items-center">
		<div
			class="w-full h-2 flex gap-0.5 overflow-hidden rounded-md"
			:class="getBarColor(strength, true)">
			<div
				:class="[ 'h-2', getBarColor(strength) ]"
				:style="`width: ${strength}%`" />
		</div>
		<span>
			{{ $t(`passwords.${message}`) }}
		</span>
	</div>
</template>
