<script setup>
import { computed, onMounted, ref } from 'vue';

const wrapperDiv = ref(null);
const containerDiv = ref(null);
const btnLeft = ref(null);
const btnRight = ref(null);

const btnLeftEnabled = ref(false);
const btnRightEnabled = ref(false);

const btnColorClass = computed(() => 'text-gray-700 hover:text-gray-500 dark:text-gray-300 dark:hover:text-white opacity-75 transition-colors');
const btnClass = computed(() => 'absolute top-1/2 cursor-pointer');


onMounted(() =>
{
	updateButtons();
});


function moveLeft()
{
	if (btnLeftEnabled.value === true)
	{
		const width = containerDiv.value.clientWidth;

		containerDiv.value.style.left = `${getContainerPosition() + width}px`;
		updateButtons();
	}
}

function moveRight()
{
	if (btnRightEnabled.value === true)
	{
		const width = containerDiv.value.clientWidth;

		containerDiv.value.style.left = `${getContainerPosition() - width}px`;
		updateButtons();
	}
}

function getContainerPosition()
{
	const pos = containerDiv.value.style.left || 0;

	return parseInt(pos);
}

function updateButtons()
{
	const wrapperRect = wrapperDiv.value.getBoundingClientRect();
	const containerRect = containerDiv.value.getBoundingClientRect();

	if (parseInt(containerDiv.value.style.left) > 0)
	{
		containerDiv.value.style.left = 0;
		btnLeftEnabled.value = containerDiv.value.style.left && parseInt(containerDiv.value.style.left) !== 0;
	}
	else if (containerRect.right < wrapperRect.right)
	{
		containerDiv.value.style.left = `-${containerRect.width - wrapperRect.width}px`;
		btnRightEnabled.value = containerRect.right < wrapperRect.right;
	}
}
</script>

<template>
	<div ref="wrapperDiv" class="relative overflow-x-hidden">
		<div ref="containerDiv"
			class="absolute left-0 top-0 flex flex-nowrap gap-x-4 px-12 w-full transition-all duration-200 ease-in"
		>
			<slot />
		</div>

		<font-awesome-icon ref="btnLeft"
			v-show="btnLeftEnabled"
			icon="circle-chevron-left"
			size="2xl"
			:class="[ 'left-0', btnClass, btnColorClass ]"
			@click="moveLeft"
		/>
		<font-awesome-icon ref="btnRight"
			v-show="btnRightEnabled"
			icon="circle-chevron-right"
			size="2xl"
			:class="[ 'right-0', btnClass, btnColorClass ]"
			@click="moveRight"
		/>
	</div>
</template>
