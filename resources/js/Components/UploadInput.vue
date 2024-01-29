<script setup>
import { computed, onMounted, ref } from 'vue';
import Button from '@/Components/Button.vue';
import ImagePreview from '@/Components/ImagePreview.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
	id: {
		type: String,
		default: '',
	},
	initialFiles: {
		default: null,
	},
	accept: {
		type: String,
		default: '*/*'
	},
	multiple: {
		type: Boolean,
		default: false,
	},
	select: {
		type: Boolean,
		default: false,
	},
	label: {
		type: String,
		default: 'Upload',
	},
	icon: {
		default: 'upload',
	},
});

const selected = defineModel('selected');
const emit = defineEmits([ 'update' ]);

const input = ref(null);
const files = ref([]);
const previews = ref([]);
const isGallery = computed(() => {
	for (const file of files.value) {
		if (!file.type.match(/^image\/.*/))
			return false;
	}
	return true;
});

onMounted(() => {
	if (props.initialFiles) {
		const initialFiles = [];

		if ((typeof props.initialFiles) === 'string')
			initialFiles.push(props.initialFiles);
		else
			props.initialFiles.forEach(f => initialFiles.push(f));

		loadFiles(initialFiles);
	}
});


async function loadFiles(initialFiles) {
	for (const file of initialFiles) {
		const response = await fetch(file);
		const blob = await response.blob();
		const name = file.split('/').pop();
		const newFile = new File([ blob ], name, { type: blob.type });
		files.value.push(newFile);
	}
	updatePreview();
	emit('update', files.value);
}


function selectFile() {
	input.value.click();
}


function update() {
	updateFiles();
	updatePreview();
	emit('update', files.value);
}


function updateFiles() {
	const uploads = input.value.files;

	if (uploads) {
		if (!props.multiple)
			files.value = [];
		files.value.push(...uploads);
	}
}


function updatePreview() {
	previews.value = [];

	for (const file of files.value) {
		const reader = new FileReader();
		let preview = null;

		reader.onload = e => {
			preview = e.target.result;
			previews.value.push(preview);
		}
		reader.readAsDataURL(file);
	}
}


function remove(index) {
	previews.value.splice(index, 1);
	delete files.value[index];
	files.value.splice(index, 1);
	emit('update', files.value, index);

	if (files.value.length === 0 && input.value?.value)
		input.value.value = null;
}
</script>

<template>
	<input
		:id="id"
		ref="input"
		type="file"
		class="hidden"
		:accept="accept"
		:multiple="multiple"
		@change="update"
	/>
	<div class="flex gap-2">
		<Button
			type="button"
			color="secondary"
			:icon="icon"
			@click.prevent="selectFile"
		>
			{{ $t(label) }}
		</Button>
	</div>
	<div v-if="previews.length > 0" class="mt-2">
		<InputLabel :value="$t('Preview')" />
		<div class="flex flex-wrap gap-2 my-2">
			<ImagePreview
				v-if="isGallery"
				v-for="(preview, index) in previews"
				:preview="preview"
				:select="select"
				:index="index"
				v-model="selected"
				@remove="() => remove(index)"
			/>
			<div v-else class="w-full border shadow-sm border-slate-500 dark:border-slate-900">
				<div
					v-for="(file, index) in files"
					class="flex align-middle gap-2 w-full px-2 py-1 bg-slate-200 odd:bg-slate-300 dark:bg-slate-700 dark:odd:bg-slate-600"
				>
					<font-awesome-icon
						class="hover:cursor-pointer text-red-500"
						icon="times"
						size="lg"
						@click="remove(index)"
					/>
					<span>{{ file.name }}</span>
				</div>
			</div>
		</div>
	</div>
</template>
