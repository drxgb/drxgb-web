<script setup>
import {ref} from 'vue';
import {Link, router, useForm} from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import Avatar from '@/Components/Avatar.vue';
import Button from '@/Components/Button.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
	user: Object,
});

const form = useForm({
	_method: 'PUT',
	name: props.user.name,
	display_name: props.user.display_name,
	email: props.user.email,
	photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);


function updateProfileInformation() {
	if (photoInput.value) {
		form.photo = photoInput.value.files[0];
	}

	form.post(route('user-profile-information.update'), {
		errorBag: 'updateProfileInformation',
		preserveScroll: true,
		onSuccess: () => clearPhotoFileInput(),
	});
};

function sendEmailVerification() {
	verificationLinkSent.value = true;
};

function selectNewPhoto() {
	photoInput.value.click();
};

function updatePhotoPreview() {
	const photo = photoInput.value.files[0];

	if (!photo) return;

	const reader = new FileReader();

	reader.onload = (e) => {
		photoPreview.value = e.target.result;
	};

	reader.readAsDataURL(photo);
};

function deletePhoto() {
	router.delete(route('current-user-photo.destroy'), {
		preserveScroll: true,
		onSuccess: () => {
			photoPreview.value = null;
			clearPhotoFileInput();
		},
	});
};

function clearPhotoFileInput() {
	if (photoInput.value?.value) {
		photoInput.value.value = null;
	}
};
</script>

<template>
	<FormSection @submitted="updateProfileInformation">
		<template #title>
			{{ $t('profile.information') }}
		</template>

		<template #description>
			{{ $t('profile.information_description') }}
		</template>

		<template #form>
			<!-- Profile Photo -->
			<div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
				<!-- Profile Photo File Input -->
				<input
					id="photo"
					ref="photoInput"
					type="file"
					class="hidden"
					@change="updatePhotoPreview">

				<InputLabel for="photo" :value="$t('profile.avatar')" />

				<!-- Current Profile Photo -->
				<div v-show="!photoPreview" class="mt-2">
					<Avatar :user="user" size="lg" />
				</div>

				<!-- New Profile Photo Preview -->
				<div v-show="photoPreview" class="mt-2">
					<span
						class="block rounded-full w-64 h-64 bg-cover bg-no-repeat bg-center"
						:style="'background-image: url(\'' + photoPreview + '\');'" />
				</div>

				<Button color="secondary" class="mt-2 me-2" type="button" @click.prevent="selectNewPhoto">
					{{ $t('profile.change_avatar') }}
				</Button>

				<Button
					v-if="user.profile_photo_path"
					color="danger"
					type="button"
					class="mt-2"
					@click.prevent="deletePhoto">
					{{ $t('profile.remove_avatar') }}
				</Button>

				<InputError :message="form.errors.photo" class="mt-2" />
			</div>

			<!-- Name -->
			<div class="col-span-6 sm:col-span-4">
				<InputLabel for="name" :value="$t('auth.username')" />
				<TextInput
					id="name"
					v-model="form.name"
					type="text"
					class="mt-1 block w-full"
					required
					autocomplete="name"
					@input="() => form.name = form.name.toLowerCase()" />
				<InputError :message="form.errors.name" class="mt-2" />
			</div>

			<!-- Display Name -->
			<div class="col-span-6 sm:col-span-4">
				<InputLabel for="name" :value="$t('profile.display_name')" />
				<TextInput
					id="display_name"
					v-model="form.display_name"
					type="text"
					class="mt-1 block w-full"
					autocomplete="display_name" />
			</div>

			<!-- Email -->
			<div class="col-span-6 sm:col-span-4">
				<InputLabel for="email" :value="$t('auth.email')" />
				<TextInput
					id="email"
					v-model="form.email"
					type="email"
					class="mt-1 block w-full"
					required
					autocomplete="username" />
				<InputError :message="form.errors.email" class="mt-2" />

				<div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
					<p class="text-sm mt-2 dark:text-white">
						{{ $t('profile.email_unverified') }}

						<Link
							:href="route('verification.send')"
							method="post"
							as="button"
							class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
							@click.prevent="sendEmailVerification">
						{{ $t('profile.resend_verification') }}
						</Link>
					</p>

					<div v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
						{{ $t('profile.send_verification_success') }}
					</div>
				</div>
			</div>
		</template>

		<template #actions>
			<ActionMessage :on="form.recentlySuccessful" class="me-3">
				{{ $t('saved') }}.
			</ActionMessage>

			<Button color="primary" icon="floppy-disk" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
				{{ $t('save') }}
			</Button>
		</template>
	</FormSection>
</template>
