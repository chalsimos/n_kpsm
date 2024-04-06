<template>

<Side />

</template>

<script>
// @ is an alias to /src
import Side from '@/views/AdminViews/Home/Sidebar.vue'

export default {
	components: {
		Side
	},
	mounted() {
		document.title = "Home";
			},};
</script>
