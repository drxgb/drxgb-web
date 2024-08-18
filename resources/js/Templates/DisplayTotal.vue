<script setup>
defineProps({
	content: Object,
});
</script>

<template>
	<div class="text-sm">
		<span v-if="content.data.length > 0">
			{{ $t('Showing') }}
			<template v-if="content.data.length >= content.total">
				{{ $t('Everything').toLowerCase() }}
			</template>

			<template v-else>
				{{ content.data.length }} {{ $t('of') }} {{ content.total }}
				{{ $t('Items').toLowerCase() }}
			</template>
		</span>

		<span v-else>
			{{ $t('No items to show') }}
		</span>
	</div>
</template>
