<script setup>
import { computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/Input/Button.vue';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () =>
{
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <AppLayout :title="$t('auth.email_verification')">
		<div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
			{{ $t('auth.email_verification_description') }}
		</div>

		<div v-if="verificationLinkSent"
			class="mb-4 font-medium text-sm text-green-600 dark:text-green-400"
		>
			{{ $t('auth.email_verification_sent') }}
		</div>

		<form @submit.prevent="submit">
			<div class="mt-4 flex items-center justify-between">
				<Button color="primary"
					:class="{ 'opacity-25': form.processing }"
					:disabled="form.processing"
				>
					{{ $t('auth.email_verification_resend') }}
				</Button>

				<div>
					<Link :href="route('profile.show')"
						class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
					>
						{{ $t('profile.edit') }}
					</Link>

					<Link :href="route('logout')"
						method="post"
						as="button"
						class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 ms-2"
					>
						{{ $t('auth.logout') }}
					</Link>
				</div>
			</div>
		</form>
	</AppLayout>
</template>
