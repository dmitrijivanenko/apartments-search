<template>
    <el-table
        :data="tableData"
        stripe
        v-loading.body="loading"
        :empty-text="'There is no data, please specify the search criteria'"
        style="width: 100%">
        <el-table-column
            prop="name"
            label="Name"
            width="180">
        </el-table-column>
        <el-table-column
            prop="bathrooms"
            label="Bathrooms"
            width="180">
        </el-table-column>
        <el-table-column
            prop="bedrooms"
            label="Bedrooms">
        </el-table-column>
        <el-table-column
            prop="storeys"
            label="Storeys">
        </el-table-column>
        <el-table-column
            prop="garages"
            label="Garages">
        </el-table-column>
        <el-table-column
            prop="price"
            label="Price">
        </el-table-column>
    </el-table>
</template>

<script>
export default {
    name: "List",
    props: ['items', 'loading'],
    data() {
        return {
            tableData: []
        }
    },
    mounted() {
        this.tableData = this.items;
    },
    updated() {
        this.tableData = this.items;
    }
}
</script>

<style scoped>

</style>
