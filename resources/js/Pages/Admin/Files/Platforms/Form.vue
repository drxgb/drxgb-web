<script setup>
import { onMounted } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminFormLayout from '@/Layouts/AdminFormLayout.vue';
import Card from '@/Components/Card.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import UploadInput from '@/Components/UploadInput.vue';

const props = defineProps({
	platform: Object,
	extensions: Object,
});

const form = useForm({
	id: null,
	name: props.platform?.name,
	short_name: props.platform?.short_name,
	extensions: props.platform?.fileExtensions || [],
	icon: null,
});

onMounted(() => {
	if (props.platform?.icon_path)
		form.icon = props.platform.icon;
});


function updateIcon(icons) {
	if (icons && icons.length > 0)
		form.icon = icons[0];
	else
		form.icon = null;
}


function submit(isUpdate) {
	if (isUpdate) {
		router.post(route('admin.platforms.update', props.platform.id), {
			_method: 'put',
			...form,
		});
	} else {
		form.post(route('admin.platforms.store'));
	}
}
</script>

<template>
	<AdminFormLayout
		:content="platform"
		:form="form"
		label="Platform"
		@form-submit="submit"
	>
			<Card size="full" no-padding>
				<div class="px-8 py-4">
					<div class="flex flex-col sm:flex-row gap-4 w-full mb-4">
						<div class="w-full sm:w-1/6">
							<InputLabel for="short-name" :value="$t('Short name')" required />
							<TextInput
								id="short-name"
								class="w-full"
								v-model="form.short_name"
								autofocus
							/>
							<InputError :message="form.errors?.short_name" />
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
						<UploadInput
							id="icon"
							ref="uploadInput"
							accept="image/png, image/bmp, image/gif"
							upload-label="Choose icon"
							@update="updateIcon"
						/>
						<InputError :message="form.errors?.icon" class="mt-2" />
					</div>

					<div class="w-full">
						<InputLabel for="file-extensions" :value="$t('File extensions')" />
						<SelectInput id="file-extensions" class="w-full h-64" multiple>
							<option
								v-for="extension in extensions"
								:value="extension.id"
								:style="`background-image: url(${extension.icon})`"
								class="bg-no-repeat pl-8"
							>
								{{ extension.name }}
							</option>
						</SelectInput>
					</div>
				</div>
			</Card>
	</AdminFormLayout>
</template>
