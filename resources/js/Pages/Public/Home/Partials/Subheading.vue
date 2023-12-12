<script setup>
defineProps({
	title: String,
});
</script>


<template>
	<section class="flex gap-24 w-2/3 mx-auto relative items-center px-12 py-12 my-24">
		<div class="w-1/2">
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
		<div class="w-1/2">
			<slot name="cover" />
		</div>
	</section>
</template>
