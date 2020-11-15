<template>
    <div>
        <el-header>
            <h3>Search for the apartments</h3>
        </el-header>
        <el-collapse>
            <el-collapse-item title="Filters" name="1">
                <el-form :label-position="labelPosition" label-width="100px">
                    <el-form-item label="Name">
                        <el-input v-model="filters.name"></el-input>
                    </el-form-item>
                    <el-form-item label="Bedrooms Qty">
                        <el-input v-model="filters.bedrooms"></el-input>
                    </el-form-item>
                    <el-form-item label="Bathrooms Qty">
                        <el-input v-model="filters.bathrooms"></el-input>
                    </el-form-item>
                    <el-form-item label="Storeys Qty">
                        <el-input v-model="filters.storeys"></el-input>
                    </el-form-item>
                    <el-form-item label="Garages Qty">
                        <el-input v-model="filters.garages"></el-input>
                    </el-form-item>
                    <el-form-item label="Price from">
                        <el-input v-model="filters.price.from"></el-input>
                    </el-form-item>
                    <el-form-item label="Price to">
                        <el-input v-model="filters.price.to"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="search">Search</el-button>
                    </el-form-item>

                </el-form>
            </el-collapse-item>
        </el-collapse>
        <list :items.sync="tableData" :loading="loading"></list>
    </div>
</template>
<script>
import List from './list';
import axios from 'axios';
export default {
    name: "Apartments",
    components: {List},
    comments: {
      List
    },
    data() {
        return {
            tableData: [],
            loading: false,
            labelPosition: 'right',
            filters: {
                name: '',
                bathrooms: null,
                bedrooms: null,
                storeys: null,
                garages: null,
                price: {
                    from: null,
                    to: null
                }
            },
        }
    },
    methods: {
        search: function() {
            let self = this;
            let params = {};
            let filters = self.filters;

            this.loading = true;

            _.forEach(filters, (filter, key) => {
               if (filter !== null && filter !== '' && key !== 'price') {
                   params[`filter[${key}]`] = filter;
               }

                if (filter !== null && key === 'price' && filter.to !== null && filter.to !== '') {
                    if (filter.from === null || filter.from === '') {
                        filter.from = 0;
                    }
                    params[`filter[${key}]`] = `${filter.from}-${filter.to}`;
                }

                if (filter !== null && key === 'price' && filter.from !== null && (filter.to === null || filter.to === '')) {
                    params[`filter[${key}]`] = `${filter.from}`;
                }
            });

            axios.get('/api/apartments', { params: params }).then((result) => {
                self.tableData = result.data;
                self.loading = false;
            }).catch((error) => {
                if (error.response && error.response.status === 400 && error.response.data.message) {
                    self.$message(error.response.data.message);
                }

                self.loading = false;
            });
        }
    }
};
</script>
<style>

</style>
