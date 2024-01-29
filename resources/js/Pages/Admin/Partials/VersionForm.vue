<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import DateInput from '@/Components/DateInput.vue';
import HrLabel from '@/Components/HrLabel.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import ProductFileForm from '@/Pages/Admin/Partials/ProductFileForm.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import UploadInput from '@/Components/UploadInput.vue';

import Forms from '@/Classes/Util/Forms';
import Versions from '@/Classes/Util/Versions';

interface Props {
	version: any,
	isUpdate: boolean,
	platforms?: any[],
};

interface ProductFile {
	name?: string,
	platform_ids: number[]|string[],
	path?: string,
	file?: any,
};

const props = withDefaults(defineProps<Props>(), {
	platforms: [],
});

const emit : any = defineEmits([ 'submit-version' ]);
const form : any = useForm({
	number: props.version?.number,
	fixes: props.version?.fixes,
	release_note: props.version?.release_notes,
	release_date: props.version?.release_date,
	files: props.version?.files || [],
});

defineExpose({
	clearErrors: () => form.clearErrors(),
	reset: () => form.reset(),
	cancel: () => form.cancel(),
});


function makeProductFile(): ProductFile {
	return <ProductFile>{
		name: null,
		platform_ids: [],
		path: null,
		file: null,
	};
}


function updateFiles(files: any[], deletedIndex: number): void {
	if (deletedIndex && form.files[deletedIndex]) {
		form.files.splice(deletedIndex, 1);
	}
	files.forEach((file: any, index: number): void => {
		if (!form.files[index]) {
			form.files[index] = makeProductFile();
		}
		form.files[index].file = file;
	});
}


function submit(): void {
	if (false) {
		emit('submit-version');
	}
}


function assign(): void {
	version.number = form.number;
	version.fixes = form.fixes;
	version.release_notes = form.release_notes;
	version.release_date = form.release_date;
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
					<InputError :message="form.release_date" />
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
					:initial-files="form.files"
					label="Add files"
					multiple
					@update="updateFiles"
				/>

				<ProductFileForm
					v-for="(file, index) in form.files"
					class="py-2 border-b border-b-slate-600 dark:border-b-slate-400"
					:platforms="platforms"
					:file="file"
					:form="form.files[index]"
				/>
			</div>
		</div>

		<div class="flex justify-center px-8 py-4 bg-slate-300 dark:bg-slate-700">
			<Button class="w-48" color="primary" icon="save">
				{{ $t('Save') }}
			</Button>
		</div>
	</form>
</template>
