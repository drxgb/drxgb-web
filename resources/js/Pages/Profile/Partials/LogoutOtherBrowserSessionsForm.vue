<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Templates/ActionMessage.vue';
import ActionSection from '@/Components/Section/ActionSection.vue';
import DialogModal from '@/Components/Modal/DialogModal.vue';
import InputError from '@/Components/Input/InputError.vue';
import Button from '@/Components/Input/Button.vue';
import PasswordInput from '@/Components/Input/PasswordInput.vue';

defineProps({
	sessions: Array,
});

const confirmingLogout = ref(false);
const passwordInput = ref(null);

const form = useForm({
	password: '',
});

const confirmLogout = () =>
{
	confirmingLogout.value = true;
	setTimeout(() => passwordInput.value.focus(), 250);
};

const logoutOtherBrowserSessions = () =>
{
	form.delete(route('other-browser-sessions.destroy'), {
		preserveScroll: true,
		onSuccess: () => closeModal(),
		onError: () => passwordInput.value.focus(),
		onFinish: () => form.reset(),
	});
};

const closeModal = () =>
{
	confirmingLogout.value = false;
	form.reset();
};
</script>

<template>
	<ActionSection>
		<template #title>
			{{ $t('profile.browser_sessions') }}
		</template>

		<template #description>
			{{ $t('profile.browser_sessions_description') }}
		</template>

		<template #content>
			<div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
				{{ $t('profile.browser_sessions_logout_description') }}
			</div>

			<!-- Other Browser Sessions -->
			<div v-if="sessions.length > 0" class="mt-5 space-y-6">
				<div v-for="(session, i) in sessions"
					:key="i"
					class="flex items-center"
				>
					<div>
						<svg v-if="session.agent.is_desktop"
							class="w-8 h-8 text-gray-500" xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"
							/>
						</svg>

						<svg v-else
							class="w-8 h-8 text-gray-500" xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"
							/>
						</svg>
					</div>

					<div class="ms-3">
						<div class="text-sm text-gray-600 dark:text-gray-400">
							{{ session.agent.platform ? session.agent.platform : $t('profile.unknown') }}
							-
							{{ session.agent.browser ? session.agent.browser : $t('profile.unknown') }}
						</div>

						<div>
							<div class="text-xs text-gray-500">
								{{ session.ip_address }},

								<span v-if="session.is_current_device" class="text-green-500 font-semibold">
									{{ $t('profile.this_device') }}
								</span>
								<span v-else>
									{{ $t('profile.last_active') }} {{ session.last_active }}
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="flex items-center mt-5">
				<Button color="danger" @click="confirmLogout">
					{{ $t('profile.log_out_browser_sessions') }}
				</Button>

				<ActionMessage :on="form.recentlySuccessful" class="ms-3">
					{{ $t('Done') }}.
				</ActionMessage>
			</div>

			<!-- Log Out Other Devices Confirmation Modal -->
			<DialogModal :show="confirmingLogout" @close="closeModal">
				<template #title>
					{{ $t('profile.log_out_browser_sessions') }}
				</template>

				<template #content>
					{{ $t('profile.please_enter_password') }}

					<div class="mt-4">
						<PasswordInput v-model="form.password"
							ref="passwordInput"
							class="mt-1 block w-3/4"
							placeholder="Password"
							autocomplete="current-password"
							@keyup.enter="logoutOtherBrowserSessions" />

						<InputError :message="form.errors.password" class="mt-2" />
					</div>
				</template>

				<template #footer>
					<Button color="secondary" @click="closeModal">
						{{ $t('Cancel') }}
					</Button>

					<Button color="primary"
						class="ms-3"
						:class="{ 'opacity-25': form.processing }"
						:disabled="form.processing"
						@click="logoutOtherBrowserSessions">
						{{ $t('profile.log_out_browser_sessions') }}
					</Button>
				</template>
			</DialogModal>
		</template>
	</ActionSection>
</template>
