<script setup>
import { ref } from 'vue';
import InputLabel from '@/Components/Input/InputLabel.vue';
import InputError from '@/Components/Input/InputError.vue';
import MultipleSelectInput from '@/Components/Input/MultipleSelectInput.vue';
import TextInput from '@/Components/Input/TextInput.vue';

const props = defineProps({
	platforms: Array,
	file: Object,
	form: Object,
	errors: Object,
});
const emit = defineEmits([ 'update' ]);

const selectedPlatforms = ref([]);


function updatePlatformFields(options)
{
	options = options.map(option => Number(option));
	selectedPlatforms.value = props.platforms.filter(platform => options.includes(platform.id));
	emit('update', {
		platforms: selectedPlatforms.value,
	});
}


function getFileName()
{
	let name;

	if (props.file.product_file) {
		name = props.file.product_file.name;
		return name.substring(0, name.lastIndexOf('.'));
	}
}
</script>

<template>
	<section>
		<!-- Nome -->
		<div>
			<InputLabel for="filename" :value="$t('Name')" />
			<TextInput v-model="form.name"
				id="filename"
				class="w-full"
				:placeholder="getFileName()"
			/>
			<InputError :message="errors?.file" />
		</div>

		<!-- Plataformas -->
		<div class="my-2">
			<InputLabel :value="$t('Platforms')" required />
			<MultipleSelectInput
				class="w-full"
				:value="file.platform_ids"
				@change-option="updatePlatformFields"
			>
				<option v-for="platform in platforms"
					:value="platform.id"
					:style="`background-image: url(${platform.icon})`"
					class="bg-no-repeat pl-12 pt-2 h-[40px]"
				>
					{{ platform.short_name }} - {{ platform.name }}
				</option>
			</MultipleSelectInput>
			<InputError :message="errors?.platform" />
		</div>
	</section>
</template>
