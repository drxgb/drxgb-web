<script setup>
const props = defineProps({
	orientation: {
		type: String,
		default: 'horizontal',
	},

	full: {
		type: Boolean,
		default: true,
	},
});

function isHorizontal() {
	const orientation = props.orientation.toLowerCase();
	return orientation === 'horizontal' || orientation === 'h';
}

function isVertical() {
	const orientation = props.orientation.toLowerCase();
	return orientation === 'vertical' || orientation === 'v';
}
</script>

<template>
	<div>
		<hr
			v-if="isHorizontal()"
			class="my-4"
			:class="{ 'w-5/6 mx-auto': !full }"
		/>

		<span
			v-else-if="isVertical()"
			class="mx-4 border-l border-l-gray-600 dark:border-l-gray-100"
			:class="{ 'h-5/6 my-auto': !full }"
		/>
	</div>
</template>
