<script setup>
import { computed, onMounted, ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import Card from '@/Components/Card.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
	fileExtension: Object,
});

const form = useForm({
	id: null,
	name: props.fileExtension?.name,
	extension: props.fileExtension?.extension,
	icon: null,
});

const iconInput = ref(null);
const iconPreview = ref(null);
const title = computed(() => {
	if (isUpdate) {
		return `${trans('Edit')} ${trans(props.fileExtension.name)}`;
	}
	return `${trans('Create')} ${trans('File extension').toLowerCase()}`;
});
let isUpdate = false;

onMounted(() => {
	if (props.fileExtension) {
		isUpdate = true;
		form.id = props.fileExtension.id;
		if (props.fileExtension.icon_path)
			iconPreview.value = props.fileExtension.icon;
	}
});


function selectIcon() {
	iconInput.value.click();
}


function updateIconPreview() {
	const icon = iconInput.value.files[0];

	if (icon) {
		const reader = new FileReader();

		reader.onload = e => iconPreview.value = e.target.result;
		reader.readAsDataURL(icon);
	}
}


function removeIcon() {
	iconPreview.value = null;
	if (iconInput.value?.value)
		iconInput.value.value = null;
}


function submit() {
	if (iconInput.value)
		form.icon = iconInput.value.files[0];

	if (isUpdate) {
		router.post(route('admin.file-extensions.update', props.fileExtension.id), {
			_method: 'put',
			id: form.id,
			name: form.name,
			extension: form.extension,
			icon: form.icon,
			deleteIcon: iconPreview.value === null,
		});
	} else {
		form.post(route('admin.file-extensions.store'));
	}
}
</script>

<template>
	<AdminLayout :title="title">
		<form @submit.prevent="submit">
			<Card size="full" no-padding>
				<div class="px-8 py-4">
					<div class="flex flex-col sm:flex-row gap-4 w-full mb-4">
						<div class="w-full sm:w-1/6">
							<InputLabel for="extension" :value="$t('Extension')" required />
							<TextInput
								id="extension"
								class="w-full"
								v-model="form.extension"
								autofocus
							/>
							<InputError :message="form.errors?.extension" />
						</div>
						<div class="w-full sm:w-5/6">
							<InputLabel for="name" :value="$t('Name')" required />
							<TextInput
								id="name"
								class="w-full"
								v-model="form.name"
								autofocus
							/>
							<InputError :message="form.errors?.name" />
						</div>
					</div>

					<div class="mb-4">
						<InputLabel for="icon" :value="$t('Icon')" />
						<input
							id="icon"
							ref="iconInput"
							type="file"
							class="hidden"
							accept="image/png, image/jpeg, image/gif"
							@change="updateIconPreview"
						/>
						<div class="flex gap-2">
							<Button type="button" color="secondary" @click.prevent="selectIcon">
								{{ $t('Choose icon') }}
							</Button>
							<Button
								v-show="iconPreview"
								type="button"
								color="danger"
								icon="times"
								@click.prevent="removeIcon">
								{{ $t('Remove icon') }}
							</Button>
						</div>
						<InputError :message="form.errors?.icon" class="mt-2" />
					</div>
					<div v-if="iconPreview">
						<InputLabel :value="$t('Preview')" />
						<img
							:src="iconPreview"
							:alt="$t('Preview')"
							class="max-w-8"
						/>
					</div>
				</div>

				<progress v-if="form.progress" :value="form.progress.percentage" max="100">
					{{ form.progress.percentage }}%
				</progress>

				<div class="w-full px-8 py-4 rounded-b-md bg-slate-200 dark:bg-slate-700 text-center">
					<Button color="primary" icon="save" class="w-full sm:w-48">
						{{ $t('Save') }}
					</Button>
				</div>
			</Card>
		</form>
	</AdminLayout>
</template>
