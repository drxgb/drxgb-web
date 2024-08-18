<script setup lang="ts">
import Card from './Card.vue';
import type Version from '@/Classes/Models/Version';
import type Platform from '@/Classes/Models/Platform';
import Versions from '@/Classes/Utils/Versions';

interface Props {
	version: Version
};

const props = defineProps<Props>();

function getAllSupportedPlatforms() : Platform[]
{
	const platforms : Set<Platform> = new Set();

	for (const file of props.version.files)
	{
		for (const supportedPlatform of file.supported_platforms)
		{
			platforms.add(supportedPlatform);
		}
	}

	return [ ...platforms ];
}
</script>

<template>
    <Card size="full">
		<div class="flex items-center justify-between w-full">
			<h1 class="text-3xl">{{ Versions.toString(version.number as number) }}</h1>
			<h2 class="text-xl">{{ version.release_date }}</h2>
		</div>

			<div class="flex items-center justify-between w-full">
			<h3 class="text-lg w-1/3">
				{{ version.files.length }}
				{{ (version.files.length === 1 ? $t('File') : $t('Files')).toLowerCase() }}
			</h3>

			<div class="flex flex-row-reverse flex-wrap gap-1 w-2/3">
				<div
					v-for="platform in getAllSupportedPlatforms().reverse()"
					class="flex flex-col gap-y-2"
				>
					<img
						:src="platform.icon"
						:alt="platform.name"
						:title="platform.name"
					/>
					<small>{{ platform.short_name }}</small>
				</div>
			</div>
		</div>

		<div class="my-4" v-if="version.release_notes">
			<h2 class="text-2xl mb-2">{{ $t('Release notes') }}</h2>
			<p class="text-justify">{{ version.release_notes }}</p>
		</div>

		<div class="my-4" v-if="version.fixes">
			<h2 class="text-2xl mb-2">{{ $t('Fixes') }}</h2>
			<p class="text-justify">{{ version.fixes }}</p>
		</div>
	</Card>
</template>
