<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Alert from '@/Components/Alert.vue';
import Button from '@/Components/Button.vue';
import Paginator from '@/Components/Paginator.vue';
import DataColumn from '@/Classes/Layouts/DataColumn';
import DisplayTotal from '@/Components/DisplayTotal.vue';
import Modal from '@/Components/Modal.vue';
import Tooltip from '@/Components/Tooltip.vue';

interface Props {
	content: any;
	context: string;
	viewable?: boolean;
	editable?: boolean;
	eraseable?: boolean;
	title?: string;
	columns?: DataColumn[];
	nameKey?: string;
}

const props = withDefaults(defineProps<Props>(), {
	viewable: true,
	editable: true,
	eraseable: true,
	nameKey: 'name',
});

const cellClasses: string = 'px-4 py-1 text-sm lg:text-base';
const headClasses: string =
	'border-sky-300 bg-sky-200 text-sky-500 dark:border-sky-400 dark:bg-sky-700 dark:text-sky-200';
const bodyClasses: string =
	'border-sky-200 bg-sky-50 text-sky-400 odd:bg-sky-100 dark:border-sky-500 dark:bg-sky-600 dark:text-sky-50 dark:odd:bg-sky-500';

const dataItem = ref<any>(null);
const confirmDeletion = ref<boolean>(false);
const form = useForm({});

function openDeleteModal(item) {
	dataItem.value = item;
	confirmDeletion.value = true;
}

function closeDeleteModal() {
	confirmDeletion.value = false;
}

function deleteItem(item) {
	// @ts-ignore
	form.delete(route(`${props.context}.destroy`, item.id), {
		preserveScroll: true,
		onSuccess: () => closeDeleteModal(),
	});
}
</script>

<template>
	<Alert v-if="$page.props.flash.message" type="success" timeout="10" can-close>
		{{ $page.props.flash.message }}
	</Alert>

	<div class="flex flex-row-reverse my-4">
		<Button
			type="button"
			color="primary"
			icon="plus"
			:href="route(`${context}.create`)"
		>
			{{ $t('Create') }}
			<template v-if="title">
				{{ $t(title) }}
			</template>
		</Button>
	</div>

	<Paginator :data="content" class="my-2" />

	<table
		class="w-full my-4 border-separate border-spacing-0 border-2 rounded-md border-sky-500"
	>
		<thead>
			<tr>
				<th
					v-for="column of columns"
					:class="[headClasses, cellClasses, 'text-left', column.classStyle]"
				>
					{{ $t(column.label) }}
				</th>
				<th :class="[headClasses, cellClasses, 'w-48']">
					{{ $t('Actions') }}
				</th>
			</tr>
		</thead>

		<tbody>
			<tr v-for="item of content.data" :class="bodyClasses">
				<template v-if="columns">
					<td
						v-for="column of columns"
						:class="[cellClasses, column.classStyle]"
						v-html="column.getValue(item)"
					/>
				</template>
				<template v-else>
					<td :class="cellClasses">
						<slot>{{ item }}</slot>
					</td>
				</template>
				<td :class="[cellClasses, 'w-48']">
					<div class="flex flex-col md:flex-row gap-2 justify-around">
						<Tooltip v-if="viewable">
							<template #label>
								<Button
									type="button"
									color="secondary"
									icon="eye"
									:href="route(`${context}.show`, item.id)"
								/>
							</template>
							{{ $t('View') }}
						</Tooltip>
						<Tooltip v-if="editable">
							<template #label>
								<Button
									type="button"
									color="warning"
									icon="edit"
									:href="route(`${context}.edit`, item.id)"
								/>
							</template>
							{{ $t('Edit') }}
						</Tooltip>
						<Tooltip v-if="eraseable">
							<template #label>
								<Button
									type="button"
									color="danger"
									icon="trash"
									@click="openDeleteModal(item)"
								/>
							</template>
							{{ $t('Delete') }}
						</Tooltip>
					</div>
				</td>
			</tr>
		</tbody>

		<tfoot>
			<tr>
				<td
					:colspan="columns.length + 1"
					:class="['px-4 py-2 text-xs', headClasses]"
				>
					<DisplayTotal :content="content" />
				</td>
			</tr>
		</tfoot>
	</table>

	<Paginator :data="content" class="my-2" />

	<Modal
		v-if="dataItem"
		type="warning"
		:show="confirmDeletion"
		@close="closeDeleteModal()"
	>
		<template #header> {{ $t('Delete') }} {{ $t(dataItem[nameKey]) }} </template>

		<div class="px-8 py-4">
			<p>
				{{ $t('Are you sure to delete') }}
				<strong>{{ $t(dataItem[nameKey]) }}</strong
				>?
			</p>
			<p>
				{{ $t('This action is irreversible') }}.
				{{
					$t(
						'Once it is deleted, all of its resources and data will be permanently deleted.'
					)
				}}
			</p>
			<p class="my-4">{{ $t('Confirm exclusion') }}?</p>
		</div>

		<template #footer>
			<form @submit="deleteItem(dataItem)">
				<Button color="danger" icon="trash" class="w-32">
					{{ $t('Yes') }}
				</Button>
			</form>
			<Button
				color="secondary"
				icon="times"
				class="w-32"
				@click.prevent="closeDeleteModal()"
			>
				{{ $t('No') }}
			</Button>
		</template>
	</Modal>
</template>
