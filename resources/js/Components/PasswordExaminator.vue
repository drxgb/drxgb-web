<script setup lang="ts">
import { computed } from 'vue';
import { PasswordMeter } from '@/Classes/Security/PasswordMeter.ts';

const props = defineProps<{
	value: string,
}>();

const meter: PasswordMeter = new PasswordMeter;
const password = computed<object>(() => {
	const strength = meter.check(props.value);
	let key = 'no_password';

	return { strength, key }
});
</script>


<template>
	<div>
		<div class="w-full h-2 flex gap-0.5 mb-2">
			<div class="w-1/3 rounded-l-md bg-red-200">
				<div />
			</div>
			<div class="w-1/3 bg-yellow-200">
				<div />
			</div>
			<div class="w-1/3 rounded-r-md bg-green-200">
				<div />
			</div>
		</div>
		<span>
			{{ $t(`passwords.${password.key}`) }}: {{ password.strength }}
		</span>
	</div>
</template>
