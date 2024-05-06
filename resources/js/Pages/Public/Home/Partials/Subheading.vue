<script setup>
defineProps({
	title: String,
});
</script>


<template>
	<section class="flex flex-col lg:flex-row gap-4 lg:gap-24 w-full lg:w-2/3 mx-auto relative items-center px-0 sm:px-12 py-12 my-2 sm:my-4 lg:my-24">
		<div class="w-full lg:w-1/2 px-2 lg:px-0">
			<h1 class="text-5xl font-bold mb-8">
				{{ title }}
			</h1>
			<p class="text-justify my-8">
				<slot name="description" />
			</p>
			<div class="w-full relative">
				<slot name="action" />
			</div>
		</div>
		<div class="w-full lg:w-1/2">
			<slot name="cover" />
		</div>
	</section>
</template>
