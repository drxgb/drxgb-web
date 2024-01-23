<script setup>
import { computed, onMounted, ref } from 'vue';
import { trans } from 'laravel-vue-i18n';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Button from '@/Components/Button.vue';

const props = defineProps({
	content: Object,
	label: String,
	form: Object,
});

defineEmits([ 'form-submit' ]);

const isUpdate = ref(false);
const title = computed(() => (isUpdate.value)
		? `${trans('Edit')} ${trans(props.content.name)}`
		: `${trans('Create')} ${trans(props.label).toLowerCase()}`
);

onMounted(() => {
	if (props.content) {
		isUpdate.value = true;
		props.form.id = props.content.id;
	}
});
</script>

<template>
	<AdminLayout :title="title">
		<form @submit.prevent="$emit('form-submit', isUpdate)">
			<slot />

			<progress v-if="form.progress" :value="form.progress.percentage" max="100">
				{{ form.progress.percentage }}%
			</progress>

			<div class="w-full px-8 py-4 rounded-b-md bg-slate-200 dark:bg-slate-700 text-center">
				<Button color="primary" icon="save" class="w-full sm:w-48">
					{{ $t('Save') }}
				</Button>
			</div>
		</form>
	</AdminLayout>
</template>
