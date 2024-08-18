<script setup>
import { ref, computed, useSlots } from 'vue';

const slot = useSlots();
const open = ref(false);
const icon = computed(() => open.value === true ? 'chevron-down' : 'chevron-right');
const hasChildren = () => !!slot.children;

function toggleChildren()
{
	if (hasChildren())
	{
		open.value = !open.value;
	}
}
</script>


<template>
	<div class="w-full border-b-2 py-2 border-b-neutral-600">
		<div class="flex justify-between px-2" @click="toggleChildren">
			<slot />
			<font-awesome-icon v-if="hasChildren()" :icon="icon" />
		</div>
		<transition
			v-if="hasChildren()"
			enter-active-class="transition ease-out duration-200"
			enter-from-class="transform scale-y-0"
			enter-to-class="transform scale-y-100"
			leave-active-class="transition ease-in duration-100"
			leave-from-class="transform scale-y-100"
			leave-to-class="transform scale-y-0">
			<div v-show="open" class="pl-4 origin-top">
				<slot name="children" />
			</div>
		</transition>
	</div>
</template>
