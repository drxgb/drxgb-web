<script setup>
import { computed } from 'vue';
import SectionTitle from './SectionTitle.vue';

const props = defineProps({
	color: {
		type: String,
		default: 'none',
	}
});

const defaultClass = 'px-4 py-5 sm:p-6 shadow sm:rounded-lg';
const colorClass = computed(() =>
{
	switch (props.color)
	{
		case 'danger':	return 'bg-red-400 text-white';
		default:		return 'bg-white dark:bg-gray-800';
	}
});
</script>

<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <SectionTitle :color="color">
            <template #title>
                <slot name="title" />
            </template>

            <template #description>
                <slot name="description" />
            </template>
        </SectionTitle>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div :class="[ defaultClass, colorClass ]">
                <slot name="content" />
            </div>
        </div>
    </div>
</template>
