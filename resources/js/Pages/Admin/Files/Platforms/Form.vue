<script setup>
import { onMounted } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminFormLayout from '@/Layouts/AdminFormLayout.vue';
import Card from '@/Components/Card/Card.vue';
import InputLabel from '@/Components/Input/InputLabel.vue';
import InputError from '@/Components/Input/InputError.vue';
import TextInput from '@/Components/Input/TextInput.vue';
import MultipleSelectInput from '@/Components/Input/MultipleSelectInput.vue';
import UploadInput from '@/Components/Input/UploadInput.vue';

const props = defineProps({
	platform: Object,
	extensions: Object,
});

const form = useForm({
	id: null,
	name: props.platform?.name,
	short_name: props.platform?.short_name,
	file_extensions:
		props.platform?.supported_file_extensions.map(ext => ext.id) || [],
	icon: null,
});

onMounted(() =>
{
	if (props.platform?.icon_path)
		form.icon = props.platform.icon;
});


function updateIcon(icons)
{
	if (icons && icons.length > 0)
		form.icon = icons[0];
	else
		form.icon = null;
}


function submit(isUpdate)
{
	if (isUpdate)
	{
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
	<AdminFormLayout :content="platform"
		:form="form"
		label="Platform"
		@form-submit="submit"
	>
			<Card size="full" no-padding>
				<div class="px-8 py-4">
					<div class="flex flex-col sm:flex-row gap-4 w-full mb-4">
						<div class="w-full sm:w-1/6">
							<InputLabel for="short-name" :value="$t('Short name')" required />
							<TextInput v-model="form.short_name"
								id="short-name"
								class="w-full"
								autofocus
							/>
							<InputError :message="form.errors?.short_name" />
						</div>
						<div class="w-full sm:w-5/6">
							<InputLabel for="name" :value="$t('Name')" required />
							<TextInput v-model="form.name"
								id="name"
								class="w-full"
								autofocus
							/>
							<InputError :message="form.errors?.name" />
						</div>
					</div>

					<div class="mb-4">
						<InputLabel for="icon" :value="$t('Icon')" />
						<UploadInput ref="uploadInput"
							id="icon"
							accept="image/png, image/bmp, image/gif"
							:label="$t('Choose icon')"
							:initial-files="platform?.icon_path ? platform.icon : null"
							@update="updateIcon"
						/>
						<InputError :message="form.errors?.icon" class="mt-2" />
					</div>

					<div class="w-full">
						<InputLabel for="file-extensions" :value="$t('File extensions')" />
						<MultipleSelectInput id="file-extensions"
							class="w-full"
							size="15"
							:value="form.file_extensions"
							@change-option="options => form.file_extensions = options"
						>
							<option v-for="extension in extensions"
								:value="extension.id"
								:style="`background-image: url(${extension.icon})`"
								class="bg-no-repeat pl-8"
							>
								.{{ extension.extension }} - {{ extension.name }}
							</option>
						</MultipleSelectInput>
					</div>
				</div>
			</Card>
	</AdminFormLayout>
</template>
