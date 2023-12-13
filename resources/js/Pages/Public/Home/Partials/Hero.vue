<script setup>
import Button from '@/Components/Button.vue';
</script>


<template>
	<section class="px-4 lg:px-48 pt-12 flex items-center text-slate-100 relative bg-hero-pattern bg-center">
		<div class="pr-0 pb-24 lg:pb-0 lg:pr-24 z-10">
			<h6 class="text-sm">
				{{ $t('Games, tools and plugins') }}
			</h6>
			<h1 class="text-4xl sm:text-6xl mb-8">
				{{ $t('Boost your workflow to beyond!') }}
			</h1>
			<p class="text-justify my-4">
				{{ $t('home.head_description') }}
			</p>
			<div class="flex gap-4 flex-col mt-8 sm:flex-row">
				<Button color="primary" size="lg">
					{{ $t("I'm a Game Developer") }}
				</Button>
				<Button color="secondary" size="lg">
					{{ $t("I'm a Software Developer") }}
				</Button>
				<Button color="success" size="lg">
					{{ $t("I'm a Forum Manager") }}
				</Button>
			</div>
		</div>

		<img
			src="/img/drxgb.png"
			:alt="$page.props.appName"
			class="z-10 hidden lg:block" />
	</section>
</template>
