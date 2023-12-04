<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/Button.vue';
import Card from '@/Components/Card.vue';
import Checkbox from '@/Components/Checkbox.vue';
import FormRow from '@/Components/FormRow.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PasswordExaminator from '@/Components/PasswordExaminator.vue';
import TextInput from '@/Components/TextInput.vue';
import Tooltip from '@/Components/Tooltip.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

function submit() {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head :title="$t('auth.register_title')" />

	<AppLayout>
		<section class="flex flex-col justify-center items-center h-full py-8">
			<h1 class="text-2xl uppercase">{{ $t('auth.register_title') }}</h1>

			<Card :no-padding="true" size="md">
				<form @submit.prevent="submit" class="pr-4">
					<!-- Usuário -->
					<FormRow>
						<template #label>
							<InputLabel for="name" :value="$t('auth.username')" />
						</template>
						<div>
							<TextInput
								id="name"
								v-model="form.name"
								type="text"
								class="mt-1 block w-full"
								required
								autofocus
								autocomplete="name"
							/>
							<InputError class="mt-2" :message="form.errors.name" />
						</div>
					</FormRow>

					<!-- Email -->
					<FormRow>
						<template #label>
							<InputLabel for="email" :value="$t('auth.email')" />
						</template>
						<div class="mt-4">
							<TextInput
								id="email"
								v-model="form.email"
								type="email"
								class="mt-1 block w-full"
								required
								autocomplete="username"
							/>
							<InputError class="mt-2" :message="form.errors.email" />
						</div>
					</FormRow>

					<!-- Senha -->
					<FormRow>
						<template #label>
							<InputLabel for="password" :value="$t('auth.password')" />
						</template>
						<div class="mt-4">
							<div class="flex justify-between items-center gap-2">
								<TextInput
									id="password"
									v-model="form.password"
									type="password"
									class="mt-1 block w-full"
									required
									autocomplete="new-password"
								/>

								<Tooltip>
									<template #label>
										<font-awesome-icon
											icon="circle-question"
											class="text-blue-600 dark:text-blue-400"
										/>
									</template>

									{{ $t('validation.min.string', {
										attribute: $t('auth.password'),
										min: $page.props.passwordMinLength
									}) }}
									{{ $t('auth.password_recomendations') }}
								</Tooltip>
							</div>
							<InputError class="mt-2" :message="form.errors.password" />
						</div>
					</FormRow>

					<!-- Medidor de força da senha -->
					<FormRow>
						<PasswordExaminator class="mt-4" :value="form.password" />
					</FormRow>

					<!-- Confirmação da senha -->
					<FormRow>
						<template #label>
							<InputLabel for="password_confirmation" :value="$t('auth.confirm_password')" />
						</template>
						<div class="mt-4">
							<TextInput
								id="password_confirmation"
								v-model="form.password_confirmation"
								type="password"
								class="mt-1 block w-full"
								required
								autocomplete="new-password"
							/>
							<InputError class="mt-2" :message="form.errors.password_confirmation" />
						</div>
					</FormRow>

					<!-- Termos de Serviço e Políticas de Privacidade -->
					<FormRow>
						<div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
							<InputLabel for="terms">
								<div class="flex items-center">
									<Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

									<div class="ms-2">
										{{ $t('auth.i_agree_to_the') }}
										<a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
											{{ $t('auth.terms_of_service') }}
										</a>
										{{ $t('and') }}
										<a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
											{{ $t('auth.privacy_policy') }}
										</a>
									</div>
								</div>
								<InputError class="mt-2" :message="form.errors.terms" />
							</InputLabel>
						</div>
					</FormRow>

					<!-- Envio do formulário -->
					<FormRow>
						<div class="flex flex-col md:flex-row items-center justify-end my-4 gap-2">
							<Link :href="route('login')" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
								{{ $t('auth.already_registered') }}
							</Link>

							<Button
								color="primary"
								icon="arrow-right-to-bracket"
								class="ms-4"
								:class="{ 'opacity-25': form.processing }"
								:disabled="form.processing">
								{{ $t('auth.register') }}
							</Button>
						</div>
					</FormRow>
				</form>
			</Card>
		</section>
	</AppLayout>
</template>
