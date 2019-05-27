<template>

    <div class="row">

        <div class="col-sm-12 form-group">

            <div class="row">

                <div class="col-sm-6">

                    <h2>{{ title }} продукта</h2>

                </div>

                <div class="col-sm-6">
                    <button class="btn btn-success pul" @click="add()">Создать {{ title}}</button>
                </div>

            </div>

        </div>

        <div class="col-sm-12">

            <div class="row">

                <div class="col-sm-6">

                    <div class="form-group">
                        <label>Имя {{ title }}</label>
                        <input type="text" v-model="data.name" @keyup.enter="add()" class="form-control">

                    </div>

                </div>

                <div class="col-sm-6" v-if="isFormat">

                    <div class="form-group">
                        <label>Тип {{ title }}</label>
                        <select v-model="data.format" class="form-control">
                            <option value="input">Текст</option>
                            <option value="list">Список</option>
                        </select>
                    </div>

                </div>

                <div class="col-sm-12" v-if="data.format != 'input'">

                    <div class="input-group form-group" v-for="(val, index) in options">
                        <input type="text" v-model="val.name" class="form-control">
                        <div class="input-group-append">
                            <button class="btn btn-danger" @click="remove_option(index)"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="btn-block">
                            <button class="btn btn-primary" @click="add_option()">Добавить</button>
                        </div>
                    </div>

                </div>

                <div class="col-sm-12">

                    <table class="table table-hover" style="width:100%;">

                        <thead>
                        <tr>
                            <th>название</th>
                            <th v-if="isFormat">тип</th>
                            <th v-if="isList"></th>
                            <th class="text-right"></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="(i, index) in attributes">
                            <td class="text-left" v-if="!i.change">{{ i.name }}</td>
                            <td class="text-left" v-if="!i.change && isFormat">{{ i.format }}</td>

                            <td v-if="i.change">
                                <input type="text" class="form-control" v-model="i.name">
                            </td>
                            <td v-if="i.change && isFormat">
                                <select  v-model="i.format" class="form-control">
                                    <option value="input">Текст</option>
                                    <option value="list">Список</option>
                                </select>
                            </td>

                            <td v-if="i.change && isFormat && i.format == 'list'">
                                <button class="btn btn-secondary" v-if="i.change" @click="list(i)">list</button>
                            </td>

                            <td v-if="isList &&i.format == 'input'">
                            </td>

                            <td class="text-right">
                                <button class="btn btn-success btn-sm" v-if="i.change" @click="update(i)"><i class="fas fa-check-circle"></i></button>

                                <button class="btn btn-info btn-sm" @click="change(i)"><i class="fas fa-cog"></i></button>

                                <button v-if="!i.change" class="btn btn-danger  btn-sm" @click="remove(i.id)"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <modal v-if="showModal" :tag_id="tag_id" :name="tag_name" @close="showModal = false"></modal>

    </div>

</template>

<script>

    import axios from 'axios'
    import Modal from './ListModal'

    export default {
        props: [
            'title',
            'isFormat',
            'type'
        ]
        ,
        data(){
            return {
                data: {
                    name: '',
                    types: this.type,
                    format: 'input'
                },
                isChange: false,
                attributes: [],
                options: [
                    {name: ''}
                ],
                isList: false,
                showModal: false,
                tag_id: ' ',
                tag_name: ''
            }
        },
        mounted(){
            this.fetch()
        },
        methods: {
            fetch()
            {
                axios.get(route('attribute.index', {type: this.type}))
                    .then(res => {
                    this.attributes = res.data
            })
            },
            add()
            {
                if(this.data.format == 'list'){
                    this.data.options = this.options
                }
                axios.post(route('attribute.store'), this.data)
                    .then(res => {
                    console.log(res.data)
                    this.data.name = ''
                    this.data.format = 'input'
                    this.options = []
                    this.fetch();
            })
            },
            remove(id)
            {
                axios.delete(route('attribute.destroy', {id: id}))
                    .then(res => {
                    console.log(res.data)
                this.fetch()
            })
            },
            update(data)
            {
                console.log(data)
                axios.put(route('attribute.update'), data)
                    .then(res => {
                    console.log(res.data)
                this.fetch()
            })
            },
            add_option()
            {
                this.options.push({name: ''})
            },
            remove_option(index)
            {
                this.options.splice(index, 1);
            },
            change(data)
            {
                data.change = !data.change
                if(data.format == 'list'){
                    this.isList = !this.isList
                }
            },
            list(data)
            {
                this.showModal = !this.showModal
                this.tag_id = data.id
                this.tag_name = data.name

            }

        },
        components: {
            'modal': Modal
        }
    }

</script>