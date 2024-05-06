<script setup>
import {Link} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/Button.vue';
import Hero from './Partials/Hero.vue';
import Partners from './Partials/Partners.vue';
import Reinforcement from './Partials/Reinforcement.vue';
import Subheading from './Partials/Subheading.vue';
</script>

<template>
	<AppLayout :title="$t('page.home')" full>
		<Hero />
		<Partners />

		<!-- RPG Maker plugins -->
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

		<!-- Softwares & Utilities -->
		<Subheading :title="$t('Softwares & Utilities')" class="lg:flex-row-reverse">
			<template #cover>
				<img src="/img/cover/utilities.jpg" class="rounded-md" />
			</template>
			<template #description>
				{{ $t('home.utilities_description') }}
			</template>
			<template #action>
				<Button href="/" color="primary" icon="binoculars" size="lg" class="w-full">
					{{ $t('Check it out') }}
				</Button>
			</template>
		</Subheading>

		<hr class="w-5/6 mx-auto" />

		<!-- XenForo add-ons -->
		<Subheading :title="$t('XenForo Add-ons')">
			<template #cover>
				<img src="/img/cover/xf.jpg" class="rounded-md" />
			</template>
			<template #description>
				{{ $t('home.xenforo_description') }}
			</template>
			<template #action>
				<Button href="/" color="primary" icon="cart-shopping" size="lg" class="w-full">
					{{ $t('Buy XenForo add-ons') }}
				</Button>
			</template>
		</Subheading>

		<hr class="w-5/6 mx-auto" />

		<!-- YouTube channel -->
		<Subheading :title="$t('Visit my YouTube channel')" class="lg:flex-row-reverse">
			<template #cover>
				<iframe
					class="w-full aspect-video"
					src="https://www.youtube-nocookie.com/embed/1HzXbl6iFJQ?si=kfIb1jrCQvg9WMKA"
					:title="$page.props.appName"
					allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
					allowfullscreen></iframe>
			</template>
			<template #description>
				{{ $t('home.youtube_description') }}
			</template>
			<template #action>
				<Button href="/" color="primary" fa="fab" icon="youtube" size="lg" class="w-full">
					{{ $t('Subscribe') }}
				</Button>
			</template>
		</Subheading>

		<Reinforcement />
	</AppLayout>
</template>
