<script setup>
import {Link, useForm} from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Button from '@/Components/Button.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import HrLabel from '@/Components/HrLabel.vue';
import FormRow from '@/Components/FormRow.vue';

defineProps({
	canResetPassword: Boolean,
	canRegister: Boolean,
	canUseSocialMedia: Boolean,
	status: String,
});

const form = useForm({
	email: '',
	password: '',
	remember: false,
});

const submit = () => {
	form.transform(data => ({
		...data,
		remember: form.remember ? 'on' : '',
	})).post(route('login'), {
		onFinish: () => form.reset('password'),
	});
};
</script>

<template>
	<AppLayout :title="$t('auth.login')">
		<section class="flex flex-col justify-center items-center h-full">
			<h1 class="text-2xl uppercase">{{ $t('auth.login') }}</h1>
			<Card :noPadding="true" class="pr-2 sm:pr-8">
				<div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
					{{ status }}
				</div>

				<form @submit.prevent="submit">
					<FormRow>
						<template #label>
							<InputLabel for="email" :value="$t('auth.email')" />
						</template>
						<div>
							<TextInput
								id="email"
								v-model="form.email"
								type="email"
								class="mt-1 block w-full"
								required
								autofocus
								autocomplete="username" />
							<InputError class="mt-2" :message="form.errors.email" />
						</div>
					</FormRow>

					<FormRow>
						<template #label>
							<InputLabel for="password" :value="$t('auth.password')" />
						</template>
						<div>
							<TextInput
								id="password"
								v-model="form.password"
								type="password"
								class="mt-1 block w-full"
								required
								autocomplete="current-password" />
							<InputError class="mt-2" :message="form.errors.password" />
						</div>
					</FormRow>

					<FormRow>
						<div class="block mt-4">
							<label class="flex items-center">
								<Checkbox v-model:checked="form.remember" name="remember" />
								<span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
									{{ $t('auth.remember_me') }}
								</span>
							</label>
						</div>

						<div class="flex flex-col sm:flex-row items-center mt-4 gap-4">
							<Button icon="arrow-right-to-bracket" color="primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
								{{ $t('auth.login') }}
							</Button>

							<Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
							{{ $t('auth.forgot_password') }}
							</Link>
						</div>
					</FormRow>
				</form>

				<div class="pl-2 sm:pl-8 py-4">
					<!-- Conectar com redes sociais -->
					<div v-if="canUseSocialMedia" class="flex flex-col items-center gap-2 mt-4">
						<HrLabel>{{ $t('or') }}</HrLabel>
						<span>{{ $t('auth.connect_with') }}:</span>
						<div class="flex flex-col sm:flex-row justify-center gap-4">
							<Button icon="google" color="custom" fa="fab" class="bg-google hover:bg-white text-white hover:text-google w-24">
								{{ $t('google') }}
							</Button>
							<Button icon="x-twitter" color="custom" fa="fab" class="bg-twitter hover:bg-white text-white hover:text-twitter w-24">
								{{ $t('twitter') }}
							</Button>
							<Button icon="github" color="custom" fa="fab" class="bg-white hover:bg-github text-github hover:text-white w-24">
								{{ $t('github') }}
							</Button>
						</div>
					</div>

					<!-- Registro -->
					<div v-if="canRegister" class="flex flex-col items-center gap-2 mt-4">
						<hr class="dark:border-white w-full mb-2" />
						<span>{{ $t('auth.not_registered_yet') }}</span>
						<Button icon="arrow-right-to-bracket" :href="route('register')" color="info">
							{{ $t('auth.register') }}
						</Button>
					</div>
				</div>
			</Card>
		</section>
	</AppLayout>
</template>
