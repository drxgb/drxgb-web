<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    value: {
        type: String,
        default: null,
	},
	color: {
		type: String,
		default: 'primary',
	}
});

const proxyChecked = computed({
    get()
	{
        return props.checked;
    },

    set(val)
	{
        emit('update:checked', val);
    },
});

const defaultClass = 'rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm dark:focus:ring-offset-gray-800';
const colorClass = computed(() =>
{
	switch (props.color)
	{
		case 'primary': return 'text-orange-600 dark:checked:bg-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600';
	}
});
</script>


<template>
    <input v-model="proxyChecked"
        type="checkbox"
        :value="value"
        :class="[ defaultClass, colorClass ]"
    >
</template>
