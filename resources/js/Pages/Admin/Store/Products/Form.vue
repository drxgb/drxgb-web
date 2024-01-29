<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import AdminFormLayout from '@/Layouts/AdminFormLayout.vue';
import Button from '@/Components/Button.vue';
import Card from '@/Components/Card.vue';
import CategorySelectInput from '@/Components/Admin/CategorySelectInput.vue';
import FormRow from '@/Components/FormRow.vue';
import HrLabel from '@/Components/HrLabel.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import NumberInput from '@/Components/NumberInput.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import ToggleInput from '@/Components/ToggleInput.vue';
import UploadInput from '@/Components/UploadInput.vue';
import VersionForm from '@/Pages/Admin/Partials/VersionForm.vue';

import Forms from '@/Classes/Util/Forms';

const props = defineProps<{
	product?: any,
	categories: any[],
	platforms: any[],
}>();
const form = useForm({
	title: props.product?.title,
	slug: props.product?.slug,
	page: props.product?.page,
	description: props.product?.description,
	price: props.product?.price || 0.0,
	active: props.product?.active || true,
	cover_index: props.product?.cover_index,

	category_id: props.product?.category?.id,
	versions: props.product?.versions || [],
	images: props.product?.images || [],
});
const showModal = ref<boolean>(false);
const updateVersion = ref<boolean>(false);
const version = ref<any>(null);
const versionForm = ref<any>(null);


function updateImages(images: any[]): void {
	if (images) {
		form.images = images;
	} else {
		form.images = [];
	}
}


function addVersion(): void {
	version.value = {};
	updateVersion.value = false;
	if (versionForm.value) {
		versionForm.value.clearErrors();
		versionForm.value.reset();
	}
	showModal.value = true;
}


function editVersion(version: any): void {
	version.value = version;
	updateVersion.value = true;
	showModal.value = true;
	if (versionForm.value)
		versionForm.value.clearErrors();
}


function closeModal(): void {
	if (form.isDirty) {
		if (!window.confirm(trans('All unsaved changes will be lost. Procceed?')))
			return;
	}

	showModal.value = false;
	if (versionForm.value)
		versionForm.value.cancel();
}


function submit(isUpdate: boolean): void {

}
</script>

<template>
	<AdminFormLayout
		:content="product"
		:form="form"
		label="Product"
		@form-submit="submit"
	>
		<Card class="sm:rounded-b-none" size="full" no-padding>
			<div class="px-8 py-4">
				<!-- Título -->
				<InputLabel for="title" :value="$t('Title')" required />
					<TextInput
						id="title"
						class="w-full"
						v-model="form.title"
						autofocus
					/>
				<InputError :message="form.errors?.title" />

				<div class="flex flex-col sm:flex-row gap-4 w-full my-4">
					<div class="w-full sm:w-1/2">
						<!-- Slug -->
						<InputLabel for="slug" :value="$t('Slug')" required />
						<TextInput
							id="slug"
							class="w-full"
							v-model="form.slug"
							@input="ev => form.slug = Forms.toKebabCase(ev.target.value)"
						/>
						<InputError :message="form.errors?.slug" />
					</div>
					<div class="w-full sm:w-1/2">
						<!-- Página -->
						<InputLabel for="page" :value="$t('Page')" />
						<TextInput
							id="page"
							class="w-full"
							v-model="form.page"
							@input="ev => form.page = Forms.wipeWhitespaces(ev.target.value)"
						/>
					</div>
				</div>

				<!-- Categoria -->
				<InputLabel for="category" :value="$t('Category')" />
				<CategorySelectInput
					id="category"
					class="w-full"
					v-model="form.category_id"
					:categories="categories"
				/>

				<!-- Descrição -->
				<InputLabel for="description" class="mt-4" :value="$t('Description')" />
				<TextArea
					id="description"
					class="w-full"
					v-model="form.description"
					rows="10"
				/>

				<!-- Preço -->
				<InputLabel for="price" :value="$t('Price')" required />
				<NumberInput
					id="price"
					color="secondary"
					v-model="form.price"
					min="0"
				/>
				<small v-show="form.price === 0" class="text-green-400 dark:text-green-500">
					{{ $t('Free') }}
				</small>
				<InputError :message="form.errors?.price" />

				<!-- Versões -->
				<HrLabel class="mt-4" />
				<InputLabel class="mt-4 mb-2" :value="$t('Version')" required />
				<div>
					<Button icon="plus" color="primary" @click="addVersion">
						{{ $t('Add new version') }}
					</Button>
				</div>

				<!-- Imagens -->
				<HrLabel class="mt-4" />
				<InputLabel for="images" class="mt-4 mb-2" :value="$t('Images')" />
				<UploadInput
					id="images"
					accept="image/*"
					label="Add product image"
					icon="plus"
					:initial-files="product?.images"
					v-model:selected="form.cover_index"
					multiple
					select
					@update="updateImages"
				/>
			</div>

			<!-- Ativo -->
			<FormRow>
				<template #label>
					<InputLabel for="active" class="py-4" :value="$t('Active')" />
				</template>
				<ToggleInput
					class="my-4"
					color="secondary"
					id="active"
					v-model="form.active"
				/>
			</FormRow>
		</Card>
	</AdminFormLayout>


	<Modal :show="showModal" @close="closeModal">
		<template #header>
			<template v-if="updateVersion">
				{{ $t('Edit') }} {{ version.number }}
			</template>
			<template v-else>
				{{ $t('Create') }} {{ $t('Version').toLowerCase() }}
			</template>
		</template>
		<VersionForm
			ref="versionForm"
			:version="version"
			:is-update="updateVersion"
			:platforms="platforms"
		/>
	</Modal>
</template>
