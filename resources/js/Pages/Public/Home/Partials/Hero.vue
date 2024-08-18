<script setup>
import Button from '@/Components/Input/Button.vue';
import Slide from '@/Transitions/Slide.vue';
</script>


<template>
	<section class="px-4 lg:px-48 pt-12 w-full flex items-center text-slate-100 relative bg-gradient-to-b from-green-500 to-green-200">
		<div class="pr-0 pb-24 w-full h-full lg:w-1/2 lg:pb-0 lg:pr-24 z-10">
			<h1 class="text-4xl sm:text-6xl font-bold mb-8">
				{{ $t('Boost your workflow to beyond!') }}
			</h1>
			<p class="text-xl text-justify my-4">
				{{ $t('home.head_description') }}
			</p>

			<Button :href="route('register')"
				color="primary"
				size="xl"
				class="w-full h-16"
			>
				{{ $t('Join us!') }}
			</Button>
		</div>

		<div class="justify-end w-1/2 hidden lg:flex">
			<Slide from="right" :duration="500">
				<img src="/img/drxgb.png"
					:alt="$page.props.appName"
					class="z-10"
				/>
			</Slide>
		</div>
	</section>
</template>
