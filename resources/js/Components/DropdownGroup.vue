<template>
	<div
		class="w-full [&>*:nth-child(odd)]:bg-slate-200 [&>*:nth-child(even)]:bg-slate-300 dark:[&>*:nth-child(odd)]:bg-slate-700 dark:[&>*:nth-child(even)]:bg-slate-800"
	>
		<slot />
	</div>
</template>
