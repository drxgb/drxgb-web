<script setup>
import PaginationLink from './PaginationLink.vue';

const props = defineProps({
	data: Object,
});


function isBounds(index)
{
	return index === 0 || index === props.data.links.length - 1;
}


function writeLabel(label, index)
{
	if (index === 0)
		return 'angle-left';
	else if (index === props.data.links.length - 1)
		return 'angle-right';
	return label;
}
</script>

<template>
	<div>
		<PaginationLink :url="data.current_page !== 1 ? data.first_page_url : null"
			:is-icon="true"
			label="angles-left"
		/>
		<PaginationLink v-for="(link, index) in data.links"
			:url="link.url"
			:active="link.active"
			:label="writeLabel(link.label, index)"
			:isIcon="isBounds(index)"
		/>
		<PaginationLink :url="data.current_page !== data.last_page ? data.last_page_url : null"
			:is-icon="true"
			label="angles-right"
		/>
	</div>
</template>
