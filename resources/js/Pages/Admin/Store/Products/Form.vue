<script setup lang="ts">
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
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

import type Category from '@/Classes/Models/Category';
import type Platform from '@/Classes/Models/Platform';
import type Product from '@/Classes/Models/Product';
import type ProductFile from '@/Classes/Models/ProductFile';
import type Version from '@/Classes/Models/Version';
import Versions from '@/Classes/Utils/Versions';

import Forms from '@/Classes/Utils/Forms';

const props = defineProps<{
	product?: Product;
	categories: Category[];
	platforms?: Platform[];
}>();
const form = useForm({
	title: props.product?.title,
	slug: props.product?.slug,
	page: props.product?.page,
	description: props.product?.description,
	price: props.product?.price || 0.0,
	active: props.product?.active ? 'yes' : 'no',
	cover_index: props.product?.cover_index,

	category_id: props.product?.category_id?.toString(),
	versions: props.product?.related_versions || [],
	images: props.product?.images || [],
	deleted_versions: new Set(),
});
const showModal: any = ref<boolean>(false);
const updateVersion: any = ref<boolean>(false);
const productVersion: any = ref<Version>(<Version>{});
const versionForm: any = ref<any>(null);

function supportedPlatforms(files: ProductFile[]): Platform[] {
	const platforms: Set<Platform> = new Set();

	if (files) {
		files.forEach((file: ProductFile) => {
			if (file.platform_ids) {
				file.platform_ids.forEach((id: number) => {
					const p = props.platforms.find((_p: Platform) => _p.id == id);
					if (p) platforms.add(p);
				});
			}
		});
	}

	return [...platforms];
}

function updateImages(images: any[]): void {
	if (images) {
		form.images = images;
	} else {
		form.images = [];
	}
}

function addVersion(): void {
	productVersion.value = {};
	updateVersion.value = false;
	if (versionForm.value) {
		versionForm.value.clearErrors();
		versionForm.value.reset();
	}
	showModal.value = true;
}

function editVersion(version: Version): void {
	productVersion.value = version;
	updateVersion.value = true;
	showModal.value = true;
	if (versionForm.value) {
		versionForm.value.clearErrors();
	}
}

function deleteVersion(version: Version): void {
	const index = form.versions.indexOf(version);
	if (index !== -1) {
		form.versions.splice(index, 1);
		if (version.id) form.deleted_versions.add(version.id);
	}
}

function saveVersion(version: Version) {
	if (updateVersion.value) {
		const index = form.versions.indexOf(productVersion.value);
		if (index !== -1) form.versions[index] = version;
	} else {
		form.versions.push(version);
	}

	productVersion.value = {};
	showModal.value = false;
}

function closeModal(): void {
	if (confirm(trans('All unsaved changes will be lost. Proceed?'))) {
		showModal.value = false;
		if (versionForm.value) versionForm.value.cancel();
	}
}

function submit(isUpdate: boolean): void {
	if (isUpdate) {
		// @ts-ignore
		router.post(route('admin.products.update', props.product.id), {
			_method: 'put',
			title: form.title,
			slug: form.slug,
			page: form.page,
			description: form.description,
			price: form.price,
			active: form.active === 'yes',
			cover_index: form.cover_index,

			category_id: form.category_id,
			versions: form.versions as any[],
			images: form.images,
			deleted_versions: [...form.deleted_versions] as any[],
		});
	} else {
		// @ts-ignore
		form.transform(data => ({
			...data,
			active: data.active === 'yes',
		})).post(route('admin.products.store'));
	}
}
</script>

<template>
	<AdminFormLayout
		:content="product"
		:form="form"
		label="Product"
		name-key="title"
		@form-submit="submit"
	>
		<Card class="sm:rounded-b-none" size="full" no-padding>
			<section class="px-8 py-4">
				<!-- Título -->
				<InputLabel for="title" :value="$t('Title')" required />
				<TextInput id="title" class="w-full" v-model="form.title" autofocus />
				<InputError :message="$page.props.errors?.title" />

				<div class="flex flex-col sm:flex-row gap-4 w-full my-4">
					<div class="w-full sm:w-1/2">
						<!-- Slug -->
						<InputLabel for="slug" :value="$t('Slug')" required />
						<TextInput
							id="slug"
							class="w-full"
							v-model="form.slug"
							@input="
								ev => (form.slug = Forms.toKebabCase(ev.target.value))
							"
						/>
						<InputError :message="$page.props.errors?.slug" />
					</div>
					<div class="w-full sm:w-1/2">
						<!-- Página -->
						<InputLabel for="page" :value="$t('Page')" />
						<TextInput
							id="page"
							class="w-full"
							v-model="form.page"
							@input="
								ev => (form.page = Forms.wipeWhitespaces(ev.target.value))
							"
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
					:min="0"
					:step="0.1"
				/>
				<small
					v-show="form.price === 0"
					class="text-green-400 dark:text-green-500"
				>
					{{ $t('Free') }}
				</small>
				<InputError :message="$page.props.errors?.price" />

				<!-- Versões -->
				<HrLabel class="my-4" />
				<InputLabel :value="$t('Version')" required />
				<div class="my-2">
					<Button
						type="button"
						icon="plus"
						color="primary"
						@click.prevent="addVersion"
					>
						{{ $t('Add new version') }}
					</Button>

					<table
						v-if="form.versions.length > 0"
						class="table-fixed w-full my-4 border border-gray-600 dark:border-slate-600"
					>
						<thead>
							<tr
								class="text-sm sm:text-base bg-gray-300 dark:bg-slate-700"
							>
								<th class="text-left">
									{{ $t('Version') }}
								</th>
								<th class="hidden sm:table-cell">
									{{ $t('Files') }}
								</th>
								<th>
									{{ $t('Platforms') }}
								</th>
								<th>
									{{ $t('Actions') }}
								</th>
							</tr>
						</thead>
						<tbody>
							<tr
								v-for="version in form.versions"
								class="text-center bg-gray-200 odd:bg-gray-100 dark:bg-slate-500 dark:odd:bg-slate-400"
							>
								<td class="text-left">
									{{ Versions.toString(version.number as number) }}
								</td>
								<td class="hidden sm:table-cell">
									{{ version.files?.length }}
								</td>
								<td>
									<div class="flex flex-wrap gap-2 justify-center">
										<img
											v-for="platform in supportedPlatforms(
												version.files
											)"
											:src="platform.icon"
											:alt="platform.name"
											:title="platform.name"
										/>
									</div>
								</td>
								<td>
									<div class="flex flex-wrap gap-1 justify-center">
										<Button
											type="button"
											color="warning"
											icon="edit"
											@click.prevent="editVersion(version)"
										/>
										<Button
											type="button"
											color="danger"
											icon="trash"
											@click.prevent="deleteVersion(version)"
										/>
									</div>
								</td>
							</tr>
						</tbody>
					</table>

					<InputError :message="$page.props.errors?.versions" />
				</div>

				<!-- Imagens -->
				<HrLabel class="my-4" />
				<InputLabel for="images" class="my-2" :value="$t('Images')" />
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
			</section>

			<!-- Ativo -->
			<FormRow>
				<template #label>
					<InputLabel
						for="active"
						class="py-4"
						:value="$t('Active')"
						required
					/>
				</template>
				<ToggleInput
					class="my-4"
					color="secondary"
					id="active"
					v-model="form.active"
				/>
				<InputError :message="$page.props.errors?.active" />
			</FormRow>
		</Card>
	</AdminFormLayout>

	<Modal :show="showModal" @close="closeModal">
		<template #header>
			<template v-if="updateVersion">
				{{ $t('Edit') }} {{ Versions.toString(productVersion.number) }}
			</template>
			<template v-else>
				{{ $t('Create') }} {{ $t('Version').toLowerCase() }}
			</template>
		</template>
		<VersionForm
			ref="versionForm"
			:version="productVersion"
			:is-update="updateVersion"
			:platforms="platforms"
			@submit-version="saveVersion"
		/>
	</Modal>
</template>
