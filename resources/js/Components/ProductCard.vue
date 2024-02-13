<script setup>
import Button from '@/Components/Button.vue';
import Card from '@/Components/Card.vue';

defineProps({
	product: Object,
});

function cover(product) {
	return product.cover;
}
</script>

<template>
	<Card size="full" no-padding>
		<div
			class="w-full h-[200px] bg-cover bg-center"
			:style="`background-image: url(${cover(product)})`"
		></div>
		<div class="px-4 py-2">
			<div class="my-4 min-h-[96px] flex flex-col gap-2 justify-between">
				<h1 class="mb-4">{{ product.title }}</h1>
				<template v-if="product.final_price > 0">
					<h3 v-if="product.has_discount" class="text-sm line-through">
						${{ product.price }}
					</h3>
					<h2 class="font-semibold text-3xl">${{ product.final_price }}</h2>
				</template>
			</div>

			<div class="flex flex-col gap-2">
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
		</div>
	</Card>
</template>
