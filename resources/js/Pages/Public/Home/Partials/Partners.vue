<script setup lang="ts">
interface Link
{
	href : string,
	title : string,
	src : string,
	class? : string,
};

const links : Link[] = [
	{
		href: 'https://condadobraveheart.com/',
		title: 'Condado Braveheart',
		src: '/img/brands/condado.png',
		class: 'max-h-[128px]',
	},
	{
		href: 'https://carlosdavilla.org/',
		src: '/img/brands/cats.png',
		title: 'Cats from the Underground',
		class: 'max-h-[128px]',
	},
	{
		href: 'https://cesber.wixsite.com/tocadodragao',
		title: 'Toca do Dragão',
		src: '/img/brands/toca-do-dragao.gif',
		class: 'max-h-[160px]',
	},
	{
		href: 'https://oz-digital-games.itch.io/',
		title: 'OZ Digital Games',
		src: '/img/brands/oz.png',
		class: 'max-h-[112px]',
	},
];
</script>

<template>
	<section class="px-4 sm:px-48 py-12 flex flex-wrap justify-center items-center gap-4 bg-orange-500">
		<a v-for="link of links"
			:href="link.href"
			target="_blank"
		>
			<img :src="link.src"
				:alt="link.title"
				:title="link.title"
				:class="link.class"
			/>
		</a>
	</section>
</template>
