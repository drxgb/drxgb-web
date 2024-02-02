<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import DateInput from '@/Components/DateInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import ProductFileForm from '@/Pages/Admin/Partials/ProductFileForm.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import UploadInput from '@/Components/UploadInput.vue';

import Forms from '@/Classes/Utils/Forms';
import type ProductFile from '@/Classes/Models/ProductFile';
import Versions from '@/Classes/Utils/Versions';

interface Props {
	version: any,
	isUpdate: boolean,
	platforms?: any[],
};

interface FileErrorBag {
	platform?: string,
	file?: string,
};

const props = withDefaults(defineProps<Props>(), {
	platforms: () => [],
});

const emit : any = defineEmits([ 'submit-version' ]);
const form : any = useForm({
	number: props.version?.number,
	fixes: props.version?.fixes,
	release_note: props.version?.release_notes,
	release_date: props.version?.release_date,
	version_files: props.version?.files || [],
	deleted_files: new Set,
});
const inputVersion = ref<any>({});

defineExpose({
	clearErrors: () => form.clearErrors(),
	reset: () => form.reset(),
	cancel: () => form.cancel(),
});


function makeProductFile(): ProductFile {
	return <ProductFile>{
		id: null,
		name: null,
		platform_ids: [],
		path: null,
		product_file: null,
	};
}


function getVersionFiles(files: ProductFile[]): File[] {
	return files.map(f => f.product_file);
}


function updateFiles(files: any[], deletedIndex?: number): void {
	if (deletedIndex !== undefined && form.version_files[deletedIndex]) {
		form.version_files.splice(deletedIndex, 1);
		form.deleted_files.add(deletedIndex);
	}
	files.forEach((file: any, index: number): void => {
		if (!form.version_files[index]) {
			form.version_files[index] = makeProductFile();
		}
		form.version_files[index].product_file = file;
	});
}


function updateFilePlatforms(file: ProductFile, fields: any): void {
	file.platform_ids = fields.platforms.map((platform: any) => platform.id);
}


function fileErrors(index: number): FileErrorBag {
	return <FileErrorBag>{
		platform: form.errors[`version_files.${index}.platform_ids`],
		file: form.errors[`version_files.${index}.file`],
	};
}


function submit(): void {
	form.post(route('admin.versions.save'), {
		preserveScroll: true,
		onSuccess: () => {
			assign();
			emit('submit-version', inputVersion.value);
		},
	});
}


function assign(): void {
	inputVersion.value.number = form.number;
	inputVersion.value.fixes = form.fixes;
	inputVersion.value.release_notes = form.release_notes;
	inputVersion.value.release_date = form.release_date;
	inputVersion.value.files = form.version_files;
}
</script>

<template>
	<form @submit.prevent="submit">
		<div class="px-8 py-4">
			<!-- Número da versão -->
			<div class="mb-4 flex gap-4">
				<div class="w-1/2">
					<InputLabel for="number" :value="$t('Number')" required />
					<TextInput
						class="w-full"
						id="number"
						v-model="form.number"
						@keypress="Forms.filterOnlyNumbers"
					/>
					<small>
						{{ $t('Version') }}:
						{{ Versions.toString(Number(form.number)) }}
					</small>
					<InputError :message="form.errors?.number" />
				</div>

				<!-- Data de lançamento -->
				<div class="w-1/2">
					<InputLabel for="release-date" :value="$t('Release date')" required />
					<DateInput
						class="w-full"
						id="release-date"
						v-model="form.release_date"
					/>
					<InputError :message="form.errors?.release_date" />
				</div>
			</div>

			<!-- Notas de lançamento -->
			<div class="my-2">
				<InputLabel for="release-notes" :value="$t('Release notes')" />
				<TextArea
					id="release-notes"
					class="w-full"
					v-model="form.release_notes"
				/>
			</div>

			<!-- Correções -->
			<div class="my-2">
				<InputLabel for="fixes" :value="$t('Fixes')" />
				<TextArea
					id="fixes"
					class="w-full"
					v-model="form.fixes"
				/>
			</div>

			<!-- Arquivos -->
			<div class="my-2">
				<InputLabel class="mb-2" :value="$t('Files')" required />
				<UploadInput
					:initial-files="getVersionFiles(form.version_files)"
					label="Add files"
					multiple
					@update="updateFiles"
				/>

				<ProductFileForm
					v-for="(file, index) in form.version_files"
					class="py-2 border-b border-b-slate-600 dark:border-b-slate-400"
					:platforms="platforms"
					:file="file"
					:form="form.version_files[index]"
					:errors="fileErrors(index)"
					@update="f => updateFilePlatforms(form.version_files[index], f)"
				/>
				<InputError :message="form.errors?.version_files" />
			</div>
		</div>

		<div class="flex justify-center px-8 py-4 bg-slate-300 dark:bg-slate-700">
			<Button class="w-48" color="primary" icon="save">
				{{ $t('Save') }}
			</Button>
		</div>
	</form>
</template>
