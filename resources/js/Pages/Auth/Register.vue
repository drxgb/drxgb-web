<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/Button/Button.vue';
import Card from '@/Components/Card/Card.vue';
import Checkbox from '@/Components/Input/Checkbox.vue';
import FormRow from '@/Components/Container/FormRow.vue';
import InputError from '@/Components/Input/InputError.vue';
import InputLabel from '@/Components/Input/InputLabel.vue';
import PasswordExaminator from '@/Templates/PasswordExaminator.vue';
import PasswordInput from '@/Components/Input/PasswordInput.vue';
import TextInput from '@/Components/Input/TextInput.vue';
import Tooltip from '@/Components/Container/Tooltip.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

function submit()
{
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
	<AppLayout :title="$t('auth.register_title')">
		<section class="flex flex-col justify-center items-center h-full py-8">
			<h1 class="text-2xl uppercase">{{ $t('auth.register_title') }}</h1>

			<Card :no-padding="true" size="md">
				<form @submit.prevent="submit" class="pr-4">
					<!-- Usuário -->
					<FormRow>
						<template #label>
							<InputLabel for="name"
								:value="$t('auth.username')"
							/>
						</template>
						<div>
							<TextInput v-model="form.name"
								id="name"
								type="text"
								class="mt-1 block w-full"
								required
								autofocus
								autocomplete="name"
								@input="() => form.name = form.name.toLowerCase()"
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
							<TextInput v-model="form.email"
								id="email"
								type="email"
								class="mt-1 block w-full"
								required
								autocomplete="username"
								@input="() => form.email = form.email.toLowerCase()"
							/>
							<InputError class="mt-2" :message="form.errors.email" />
						</div>
					</FormRow>

					<!-- Senha -->
					<FormRow>
						<template #label>
							<InputLabel for="password"
								:value="$t('auth.password')"
							/>
						</template>
						<div class="mt-4">
							<div class="flex justify-between items-center gap-2">
								<PasswordInput v-model:model-value="form.password"
									id="password"
									class="mt-1 block w-full"
									required
									autocomplete="new-password"
								/>

								<Tooltip>
									<template #label>
										<font-awesome-icon icon="circle-question"
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
							<InputLabel for="password_confirmation"
								:value="$t('auth.confirm_password')"
							/>
						</template>
						<div class="mt-4">
							<PasswordInput v-model="form.password_confirmation"
								id="password_confirmation"
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
									<Checkbox v-model:checked="form.terms"
										name="terms"
										id="terms"
										required
									/>

									<div class="ms-2">
										{{ $t('auth.i_agree_to_the') }}
										<a :href="route('terms.show')"
											target="_blank"
											class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
										>
											{{ $t('auth.terms_of_service') }}
										</a>
										{{ $t('And') }}
										<a :href="route('policy.show')"
											target="_blank"
											class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
										>
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
							<Link :href="route('login')"
								class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
							>
								{{ $t('auth.already_registered') }}
							</Link>

							<Button color="primary"
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
