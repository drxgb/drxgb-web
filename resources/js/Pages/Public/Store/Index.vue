<script setup>
import { ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import DisplayTotal from '@/Components/DisplayTotal.vue';
import HrLabel from '@/Components/HrLabel.vue';
import ProductCard from '@/Components/ProductCard.vue';
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
	products: Object,
	category: Object,
	subcategories: Array,
	filters: Object,
});
const page = usePage();

const showSubcategories = ref(false);
const inputSort = ref(null);
const inputPerPage = ref(null);

function breadcrumbs() {
	const items = [...page.props.breadcrumbs];
	return items;
}

function applyFilters(filters) {
	router.visit(route('store.index'), {
		data: filters,
		preserveState: true,
		preserveScroll: true,
		only: ['products'],
	});
}

function sort() {
	applyFilters({
		...props.filters,
		o: inputSort.value.input.value,
	});
}

function setPerPage() {
	applyFilters({
		...props.filters,
		p: inputPerPage.value.value,
	});
}
</script>

<template>
	<AppLayout :title="$t('Store')">
		<Breadcrumbs class="mb-4" :items="breadcrumbs()" />

		<section class="py-4 flex gap-12">
			<!-- Barra lateral -->
			<aside class="w-1/6">
				<h1 class="text-2xl">{{ $t('Related categories') }}</h1>
				<div class="py-4">
					<h3 v-if="category" class="text-xl my-2">{{ category.name }}</h3>
					<menu class="my-2" :class="{ 'ml-8': category }">
						<li v-for="(subcategory, i) in subcategories">
							<Link
								v-if="showSubcategories || (!showSubcategories && i < 4)"
								class="hover:text-orange-300"
								:href="
									route('store.index', {
										...filters,
										category: subcategory.id,
									})
								"
							>
								{{ subcategory.name }}
							</Link>
						</li>
					</menu>

					<span
						v-if="subcategories.length > 5"
						class="cursor-pointer hover:text-orange-300"
						@click="showSubcategories = !showSubcategories"
					>
						{{ $t('View more') }}
					</span>
				</div>
			</aside>

			<!-- Lista de produtos -->
			<article class="w-5/6">
				<div class="flex justify-between items-baseline">
					<div class="flex gap-4">
						<div class="mr-4">
							<span class="mr-2">
								<font-awesome-icon class="mr-1" icon="sort" />
								{{ $t('Sort by') }}
							</span>
							<SelectInput
								ref="inputSort"
								v-model="filters.o"
								@change="sort"
							>
								<option value="0">{{ $t('Most relevant') }}</option>
								<option value="1">
									{{ $t('Expensiver to cheaper') }}
								</option>
								<option value="2">
									{{ $t('Cheaper to expensiver') }}
								</option>
								<option value="3">{{ $t('Recent to older') }}</option>
								<option value="4">{{ $t('Older to recent') }}</option>
								<option value="5">{{ $t('A-Z') }}</option>
								<option value="6">{{ $t('Z-A') }}</option>
							</SelectInput>
						</div>

						<div>
							<span class="mr-2">
								<font-awesome-icon class="mr-1" icon="file-lines" />
								{{ $t('Show per page') }}
							</span>
							<SelectInput
								ref="inputPerPage"
								v-model="filters.p"
								@change="setPerPage"
							>
								<option v-for="i in 5">
									{{ i * 20 }}
								</option>
							</SelectInput>
						</div>
					</div>

					<DisplayTotal :content="products" />
				</div>

				<HrLabel class="my-4" />

				<div class="grid grid-cols-4 gap-12">
					<ProductCard v-for="product in products.data" :product="product" />
				</div>
			</article>
		</section>
	</AppLayout>
</template>
