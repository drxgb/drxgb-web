<script setup>
import ApplicationLogo from '@/Templates/ApplicationLogo.vue';
import Button from '@/Components/Input/Button.vue';
import FooterCopyright from './FooterCopyright.vue';
import LanguageButton from './LanguageButton.vue';
</script>


<template>
	<footer class="lg:px-20 sm:px-8 px-4 py-4 mt-auto bg-green-700 text-slate-100">
		<div class="flex justify-between max-sm:justify-end mb-4">
			<div class="flex gap-4 max-sm:hidden">
				<ApplicationLogo />
				<div>
					<h1 class="text-4xl">{{ $page.props.appName }}</h1>
					<h2>{{ $t('footer.games_softwares_utilities') }}</h2>
				</div>
			</div>
			<div>
				<Button icon="heart" color="primary" size="sm">
					{{ $t('footer.support_us') }}
				</Button>
			</div>
		</div>

		<hr class="border-slate-200 block max-sm:hidden" />

		<div class="flex max-sm:flex-col-reverse max-sm:text-right justify-between mt-4">
			<div class="lg:block hidden">
				<LanguageButton />
			</div>

			<FooterCopyright />

			<div class="flex gap-2 max-sm:justify-end">
				<a href="https://github.com/drxgb" target="_blank">
					<font-awesome-icon :icon="['fab', 'github']" size="2xl" class="text-github" />
				</a>
				<a href="https://drxgb.itch.io/" target="_blank">
					<font-awesome-icon :icon="['fab', 'itch-io']" size="2xl" class="text-itchio" />
				</a>
				<a href="https://gamejolt.com/@drxgb" target="_blank">
					<img src="/img/brands/gamejolt.png" class="w-[36px]" />
				</a>
				<a href="https://twitch.tv/drxgb_/" target="_blank">
					<font-awesome-icon :icon="['fab', 'twitch']" size="2xl" class="text-twitch" />
				</a>
				<a href="https://youtube.com/@DrXGB_/" target="_blank">
					<font-awesome-icon :icon="['fab', 'youtube']" size="2xl" class="text-youtube" />
				</a>
				<a href="https://twitter.com/@DrXGB_/" target="_blank">
					<font-awesome-icon :icon="['fab', 'x-twitter']" size="2xl" class="text-twitter" />
				</a>
			</div>
		</div>
	</footer>
</template>
