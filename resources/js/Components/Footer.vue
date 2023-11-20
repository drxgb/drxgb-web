<script setup lang="ts">
import ApplicationLogo from './ApplicationLogo.vue';
import PrimaryButton from './PrimaryButton.vue';
import LanguageButton from './LanguageButton.vue';
</script>


<template>
	<footer class="px-20 py-4 bg-green-600 text-slate-100">
		<div class="flex justify-between mb-4">
			<div class="flex gap-4">
				<ApplicationLogo />
				<div>
					<h1 class="text-4xl">{{ $page.props.appName }}</h1>
					<h2>{{ $t('footer.games_softwares_utilities') }}</h2>
				</div>
			</div>
			<div>
				<PrimaryButton icon="heart">
					{{ $t('footer.support_us') }}
				</PrimaryButton>
			</div>
		</div>

		<hr class="border-slate-200" />

		<div class="flex justify-between mt-4">
			<div>
				<LanguageButton />
			</div>

			<span>
				&copy;
				{{ new Date().getFullYear() }} -
				{{ $t('footer.made_with') }}
				<font-awesome-icon :icon="['fas', 'heart']" class="text-red-500" />
				{{ $t('footer.by_drxgb') }}
			</span>

			<div class="flex gap-2">
				<a href="https://github.com/drxgb" target="_blank">
					<font-awesome-icon :icon="['fab', 'github']" size="2xl" class="text-black" />
				</a>
				<a href="https://drxgb.itch.io/" target="_blank">
					<font-awesome-icon :icon="['fab', 'itch-io']" size="2xl" class="text-red-400" />
				</a>
				<a href="https://gamejolt.com/@drxgb" target="_blank">
					<img src="/img/brands/gamejolt.png" class="w-[36px]" />
				</a>
				<a href="https://twitch.tv/drxgb_/" target="_blank">
					<font-awesome-icon :icon="['fab', 'twitch']" size="2xl" class="text-[#9146FF]" />
				</a>
				<a href="https://youtube.com/@DrXGB_/" target="_blank">
					<font-awesome-icon :icon="['fab', 'youtube']" size="2xl" class="text-[#FF0000]" />
				</a>
				<a href="https://twitter.com/@DrXGB_/" target="_blank">
					<font-awesome-icon :icon="['fab', 'x-twitter']" size="2xl" class="text-black" />
				</a>
			</div>
		</div>
	</footer>
</template>
