<script setup>
import { computed } from 'vue';

const props = defineProps({
	size: {
		type: String,
		default: 'lg',
	},
	user: Object
});

const defaultClass = 'rounded-full';
const avatarSize = computed(() => {
	switch (props.size) {
		case 'xxs':		return 'w-6';
		case 'xs':		return 'w-12';
		case 'sm':		return 'w-24';
		case 'md':		return 'w-32';
		case 'lg':		return 'w-48';
		case 'xl':		return 'w-64';
		case '2xl':		return 'w-96';
	}
});
</script>


<template>
	<img :src="user.profile_photo_url"
		:alt="user.name"
		:class="[defaultClass, avatarSize]"
	/>
</template>
