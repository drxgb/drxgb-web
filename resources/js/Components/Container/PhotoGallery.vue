<script setup>
import { ref } from 'vue';
import Carousel from '@/Templates/Carousel.vue';

const props = defineProps({
	images: Array,
});

const index = ref(0);

const btnClass = 'absolute top-1/2 cursor-pointer text-5xl opacity-75 transition-colors';
const btnColorClass = 'text-gray-700 hover:text-gray-500 dark:text-slate-400 hover:dark:text-slate-500';


function prev()
{
	--index.value;

	if (index.value < 0)
		index.value = props.images?.length - 1;
}

function next()
{
	++index.value;

	if (index.value > props.images?.length - 1)
		index.value = 0;
}
</script>

<template>
	<div class="flex flex-col gap-4 relative w-full border rounded-sm select-none border-gray-300 bg-gray-200 dark:border-slate-700 dark:bg-slate-800">
		<div class="flex justify-center items-center h-[640px] relative">
			<img :src="images[index]" class="h-full" />
		</div>

		<Carousel class="h-[80px] bg-gray-300 dark:bg-slate-600">
			<img v-for="(image, i) in images"
				:src="image"
				class="h-[80px] cursor-pointer"
				:class="{ 'border-4 border-orange-500': index === i }"
				@click="index = i"
			/>
		</Carousel>

		<font-awesome-icon icon="circle-chevron-left"
			:class="[ 'left-4', btnClass, btnColorClass ]"
			@click="prev"
		/>
		<font-awesome-icon icon="circle-chevron-right"
			:class="[ 'right-4', btnClass, btnColorClass ]"
			@click="next"
		/>
	</div>
</template>
