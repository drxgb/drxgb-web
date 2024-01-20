<script setup lang="ts">
import Button from '@/Components/Button.vue';
import Paginator from '@/Components/Paginator.vue';
import DataColumn from '@/Classes/Layout/DataColumn';
import Tooltip from '@/Components/Tooltip.vue';

interface Props {
	content: any,
	context: string,
	viewable?: boolean,
	editable?: boolean,
	eraseable?: boolean,
	title?: string,
	columns?: DataColumn[],
};

withDefaults(defineProps<Props>(), {
	viewable: true,
	editable: true,
	eraseable: true,
});

const cellClasses: string = 'px-4 py-1 text-sm lg:text-base';
const headClasses: string = 'border-sky-300 bg-sky-100 text-sky-500 dark:border-sky-400 dark:bg-sky-700 dark:text-sky-200';
const bodyClasses: string = 'border-sky-200 bg-sky-50 text-sky-400 dark:border-sky-500 dark:bg-sky-600 dark:text-sky-50';
</script>

<template>
	<div class="flex flex-row-reverse my-4">
		<Button type="button" color="primary" icon="plus" :href="(route(`${context}.create`))">
			{{ $t('Create') }}
			<template v-if="title">
				{{ $t(title) }}
			</template>
		</Button>
	</div>

	<Paginator :data="content" class="my-2" />

	<table class="w-full my-4 border-separate border-spacing-0 border-2 rounded-md border-sky-500">
		<thead>
			<tr>
				<th
					v-for="column of columns"
					:class="[ headClasses, cellClasses, 'text-left', column.classStyle ]">
					{{ $t(column.label) }}
				</th>
				<th :class="[ headClasses, cellClasses, 'w-48' ]">
					{{ $t('Actions') }}
				</th>
			</tr>
		</thead>

		<tbody>
			<tr v-for="item of content.data">
				<template v-if="columns">
					<td
						v-for="column of columns"
						:class="[ bodyClasses, cellClasses, column.classStyle ]"
						v-html="column.getValue(item)" />
				</template>
				<template v-else>
					<td :class="[ bodyClasses, cellClasses ]">
						<slot>{{ item }}</slot>
					</td>
				</template>
				<td :class="[ bodyClasses, cellClasses, 'w-48' ]">
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
									:href="route(`${context}.destroy`, item.id)"
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
				<td :colspan="columns.length + 1" :class="[ 'px-4 py-2 text-xs', headClasses ]">
					{{ $t('Showing') }}
					<template v-if="content.data.length >= content.total">
						{{ $t('Everything').toLowerCase() }}
					</template>
					<template v-else>
						{{ content.data.length }} {{ $t('of') }} {{ content.total }}
						{{ $t('Items').toLowerCase() }}
					</template>
				</td>
			</tr>
		</tfoot>
	</table>

	<Paginator :data="content" class="my-2" />
</template>
