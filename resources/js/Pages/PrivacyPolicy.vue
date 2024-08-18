<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ApplicationLogo from '@/Templates/ApplicationLogo.vue';

defineProps({
    policy: String,
});
</script>

<template>
    <AppLayout :title="$t('auth.privacy_policy')">
		<div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
			<div class="pt-4 bg-gray-100 dark:bg-gray-900">
				<div class="flex flex-col items-center pt-6 sm:pt-0">
					<div>
						<ApplicationLogo />
					</div>

					<div class="w-full sm:max-w-2xl mt-6 p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert" v-html="policy" />
				</div>
			</div>
		</div>
	</AppLayout>
</template>
