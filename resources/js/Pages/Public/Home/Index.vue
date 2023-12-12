<script setup>
import {Link} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/Button.vue';
import Hero from './Partials/Hero.vue';
import Partners from './Partials/Partners.vue';
import Subheading from './Partials/Subheading.vue';
</script>

<template>
	<AppLayout :title="$t('page.home')" full>
		<Hero />
		<Partners />

		<Subheading :title="$t('Plugins for RPG Maker')">
			<template #cover>
				<img src="/img/cover/rmmv.jpg" class="rounded-md" />
			</template>
			<template #description>
				{{ $t('home.plugins_description') }}
			</template>
			<template #action>
				<div class="flex justify-around">
					<Link href="/" class="hover:animate-heart text-center">
					<img src=" /img/icon/mv.png" alt="RPG Maker MV" />
					<h3 class="text-lg font-semibold mt-2">MV</h3>
					</Link>
					<Link href="/" class="hover:animate-heart text-center">
					<img src="/img/icon/mz.png" alt="RPG Maker MZ" />
					<h3 class="text-lg font-semibold mt-2">MZ</h3>
					</Link>
				</div>
			</template>
		</Subheading>

		<hr class="w-5/6 mx-auto" />

		<Subheading :title="$t('Softwares & Utilities')" class="flex-row-reverse">
			<template #cover>
				<img src="/img/cover/utilities.jpg" class="rounded-md" />
			</template>
			<template #description>
				{{ $t('home.utilities_description') }}
			</template>
			<template #action>
				<Button href="/" color="primary" icon="binoculars" class="w-full">
					{{ $t('Check it out') }}
				</Button>
			</template>
		</Subheading>

		<hr class="w-5/6 mx-auto" />
	</AppLayout>
</template>
