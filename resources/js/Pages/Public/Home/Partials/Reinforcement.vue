<script setup>
import Button from '@/Components/Input/Button.vue';
</script>

<template>
	<section class="px-4 lg:px-48 py-20 bg-orange-500 text-center">
		<h1 class="text-6xl font-bold my-8">
			{{ $t('Join us!') }}
		</h1>
		<p class="my-8">
			{{ $t('home.login_description') }}
		</p>

		<div class="flex flex-col sm:flex-row justify-center gap-4">
			<Button :href="route('login')"
				class="w-full lg:w-80"
				icon="arrow-right-to-bracket"
				size="xl"
				color="success"
			>
				{{ $t('auth.login') }}
			</Button>
			<Button :href="route('register')"
				class="w-full lg:w-80"
				icon="arrow-right-to-bracket"
				size="xl"
				color="info"
			>
				{{ $t('auth.register') }}
			</Button>
		</div>
	</section>
</template>
