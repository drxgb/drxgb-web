<script setup>
import { computed } from 'vue';

const props = defineProps({
	color: {
		type: String,
		default: 'none',
	}
});

const titleClass = 'text-lg font-medium';
const titleColorClass = computed(() =>
{
	switch (props.color)
	{
		case 'danger':	return 'text-red-50';
		default:		return 'text-gray-900 dark:text-gray-100';
	}
});
const descriptionClass = 'mt-1 text-sm';
const descriptionColorClass = computed(() =>
{
	switch (props.color)
	{
		case 'danger':	return 'text-red-100';
		default:		return 'text-gray-600 dark:text-gray-400';
	}
});
</script>


<template>
    <div class="md:col-span-1 flex justify-between">
        <div class="px-4 sm:px-0">
            <h3 :class="[ titleClass, titleColorClass ]">
                <slot name="title" />
            </h3>

            <p :class="[ descriptionClass, descriptionColorClass ]">
                <slot name="description" />
            </p>
        </div>

        <div class="px-4 sm:px-0">
            <slot name="aside" />
        </div>
    </div>
</template>
