<template>

    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-header">
                        <slot name="header">
                            {{ name}}
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            <table class="table table-hover" style="width:100%;">

                                <thead>
                                <tr>
                                    <th>название</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr v-for="(i, index) in list">
                                    <td class="text-left" v-if="!i.change">{{ i.name }}</td>

                                    <td v-if="i.change">
                                        <input type="text" class="form-control" v-model="i.name">
                                    </td>

                                    <td class="text-right">
                                        <button class="btn btn-success btn-sm" v-if="i.change" @click="update(i)"><i class="fas fa-check-circle"></i></button>

                                        <button class="btn btn-info btn-sm" @click="change(i)"><i class="fas fa-cog"></i></button>

                                        <button v-if="!i.change" class="btn btn-danger btn-sm " @click="remove(i.id)"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                </tbody>

                            </table>
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn btn-info" @click="$emit('close')">
                                закрыть
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>

</template>

<script>

    import axios from 'axios'

    export default {

        props: [
            'name',
            'tag_id',
        ],
        mounted()
        {
          this.fetch()
        },
        data(){
            return {
                list: []
            }
        },
        methods: {
            fetch()
            {
                axios.get(route('attribute.show', {id: this.tag_id, type: 'list'}))
                    .then(res => {
                    this.list = res.data.option
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
                this.data.format = ''
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
            change(data)
            {
                data.change = !data.change
            },
        }

    }

</script>