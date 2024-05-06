<script setup lang="ts">
import { computed } from 'vue';

import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/Button.vue';
import Carousel from '@/Components/Carousel.vue';
import Divider from '@/Components/Divider.vue';
import HrTitle from '@/Components/HrTitle.vue';
import PhotoGallery from '@/Components/PhotoGallery.vue';
import ProductCard from '@/Components/ProductCard.vue';
import VersionCard from '@/Components/VersionCard.vue';
import Tooltip from '@/Components/Tooltip.vue';

import type Product from '@/Classes/Models/Product';
import type Version from '@/Classes/Models/Version';
import Versions from '@/Classes/Utils/Versions';

interface Props {
	product: Product,
	relatedProducts: Product[]
};

const props = defineProps<Props>();

const recentVersions = computed<Version[]>(() =>[ ...props.product.related_versions ].reverse());
const lastVersion = computed<Version>(() => recentVersions.value[0]);
</script>

<template>
	<AppLayout :title="product.title">
		<article class="grid grid-cols-[70%_30%] w-full">
			<section class="pr-12 py-4">
				<!-- Galeria de imagens -->
				<PhotoGallery :images="product.images" />

				<!-- Descrição -->
				<HrTitle>{{ $t('Description') }}</HrTitle>
				<p class="text-justify">
					{{ product.description }}
				</p>

				<!-- Versões -->
				<HrTitle>{{ $t('Version updates') }}</HrTitle>
				<VersionCard
					v-for="version in recentVersions"
					:version="version"
				/>

				<template v-if="relatedProducts.length > 0">
					<!-- Produtos Relacionados -->
					<HrTitle>{{ $t('Related products') }}</HrTitle>
					<Carousel class="h-[448px]">
						<div v-for="related in relatedProducts" class="w-64">
							<ProductCard :product="related"	/>
						</div>
					</Carousel>
				</template>
			</section>

			<aside class="pl-12 py-4 sticky top-0 self-start">
				<h1 class="text-4xl text-orange-500">{{ product.title }}</h1>
				<div class="flex justify-between items-center py-2">
					<small>
						+8000
						{{ $t(product.is_free ? 'Downloads' : 'Sold').toLowerCase() }}
					</small>

					<Tooltip>
						<template #label>
							<font-awesome-icon
								:icon="[ 'far', 'heart' ]"
								size="xl"
								class="cursor-pointer"
							/>
						</template>

						<span>
							{{ $t('Add to favorites') }}
						</span>
					</Tooltip>
				</div>
				<Divider />

				<div class="flex flex-col w-full gap-y-2 my-8">
					<template v-if="product.is_free">
						<Button
							icon="download"
							size="lg"
							color="primary"
							>
							{{ $t('download') }}
						</Button>
					</template>

					<template v-else>
						<h1 class="text-7xl text-green-500 font-bold mb-8">${{ product.final_price }}</h1>
						<Button
							icon="cart-shopping"
							size="lg"
							color="primary"
						>
							{{ $t('Buy') }}
						</Button>
						<Button
							icon="cart-plus"
							size="lg"
							color="secondary"
						>
							{{ $t('Add to Cart') }}
						</Button>

						<div class="flex flex-col my-4">
							<small class="text-justify">
								{{ $t('Payment method is provided by') }}
								<a href="https://stripe.com" target="_blank" class="text-orange-500 hover:text-orange-300 dark:text-orange-400 hover:dark:text-orange-200 underline transition-colors">
									{{ $t('Stripe') }}
								</a>
								{{ $t('According to your region') }}.
							</small>
							<small class="text-justify">
								{{ $t('No additional registration is required with this payment provider.') }}
							</small>
						</div>
					</template>
				</div>
				<Divider />

				<table class="table-fiexd w-full">
					<tr>
						<td class="font-bold">{{ $t('Author') }}</td>
						<td></td>
					</tr>
					<tr>
						<td class="font-bold">{{ $t('Category') }}</td>
						<td>{{ product.related_category.name }}</td>
					</tr>
					<tr>
						<td class="font-bold">{{ $t('Last version') }}</td>
						<td>{{ Versions.toString(lastVersion.number as number) }}</td>
					</tr>
					<tr>
						<td class="font-bold">{{ $t('Last update at') }}</td>
						<td>{{ lastVersion.release_date }}</td>
					</tr>
					<tr>
						<td class="font-bold">{{ $t('Files') }}</td>
						<td>{{ lastVersion.files.length }}</td>
					</tr>
				</table>
			</aside>
		</article>
	</AppLayout>
</template>
