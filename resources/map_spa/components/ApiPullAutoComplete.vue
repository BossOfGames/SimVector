<template>
	<v-autocomplete
		v-model="output"
		:loading="loading"
		:items="items"
		:search-input.sync="search"
		cache-items
		flat
		hide-no-data
		hide-details
		:label="label"
		item-text="name"
        :item-value="itemvalue"
		:return-object="returnobj"
	></v-autocomplete>
</template>
<script>
import axios from 'axios'
export default {
	name: "ApiPullAutoComplete",
	props: ['label', 'url', 'returnobj', 'itemvalue'],
	data() {
		return {
			output: null,
			loading: false,
			items: [],
			search: null
		}
	},
	watch: {
	  search (val) {
		val && val !== this.depapt && this.dep_querySelections(val)
	  },
	  output (val) {
		this.$emit('input', this.output)
	  },
	},
	methods: {
		dep_querySelections (v) {
			this.loading = true;
			this.items = [];
			axios.get(this.url, { params: { keyword: this.search }})
				.then(res => {
					this.items = res.data;
					this.loading = false;
				});
		},
	}
}
</script>
