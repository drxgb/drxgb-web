<script setup>
import Button from '@/Components/Input/Button.vue';
import Card from '@/Components/Card/Card.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
	product: Object,
});
</script>

<template>
	<Card size="full" no-padding>
		<Link :href="route('product.show', { id: product.id, slug: product.slug })">
			<div
				class="w-full h-[200px] bg-cover bg-center"
				:style="`background-image: url(${product.cover})`"
			></div>
			<div class="px-4 py-2 my-4 min-h-[96px] flex flex-col gap-2 justify-between">
				<h1 class="mb-4">{{ product.title }}</h1>
				<template v-if="product.final_price > 0">
					<h3 v-if="product.has_discount" class="text-sm line-through">
						${{ product.price }}
					</h3>
					<h2 class="font-semibold text-3xl">${{ product.final_price }}</h2>
				</template>
			</div>
		</Link>

		<div class="px-4 py-2 flex flex-col gap-2">
			<template v-if="product.final_price > 0">
				<Button color="primary" icon="cart-shopping">
					{{ $t('Buy') }}
				</Button>
				<Button color="secondary" icon="cart-plus">
					{{ $t('Add to Cart') }}
				</Button>
			</template>

			<template v-else>
				<Button color="primary" icon="download">
					{{ $t('Download') }}
				</Button>
				<span
					class="bg-green-600 rounded-md px-4 py-2 text-center text-xs font-semibold tracking-widest uppercase"
				>
					{{ $t('Free') }}
				</span>
			</template>
		</div>
	</Card>
</template>
