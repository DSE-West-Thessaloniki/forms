<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <editable-text :edittext="this.title" fid="title">
                        </editable-text>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="form-row">
                                    <label for="notes" class="col-3 col-form-label">Σημειώσεις:</label>
                                    <div class="col-9 align-self-center">
                                        <textarea id="notes" name="notes" class="col-12" v-model="notes">
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-row form-check">
                                        <input type="checkbox" class="form-check-input" id="multiple_input" name="multiple_input" value=1 v-model="multiple">
                                        <label class="form-check-label" for="multiple_input">Πολλαπλή συμπλήρωση στοιχείων φόρμας</label>
                                </div>
                            </li>
                            <draggable v-model="fields" handle=".handle" @end="dragEnded">
                                <li class="list-group-item" v-for="field in fields" :key="field.id">
                                    <vform-field-component
                                    :value.sync="field.title"
                                    :id="field.id"
                                    :type="field.type"
                                    :listvalues="field.listvalues"
                                    v-on:delfield="delField"
                                    ref='vform-fields'
                                    ></vform-field-component>
                                </li>
                            </draggable>
                            <li class="list-group-item">
                                <button
                                type="button"
                                class="btn btn-primary"
                                @click="addField"
                                >
                                    <i class="fas fa-plus-circle"></i> Προσθήκη πεδίου
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-header">
                        Διαθέσιμη σε
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="form-row">
                                    <label for="categories" class="m-2">Κατηγορίες:</label>
                                    <pillbox class="flex-fill"
                                        :options="this.categories"
                                        name="categories"
                                    >
                                    </pillbox>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-row">
                                    <label for="schools" class="m-2">Σχολικές μονάδες:</label>
                                    <pillbox class="flex-fill"
                                        :options="this.schools"
                                        placeholder="Επιλέξτε σχολική μονάδα"
                                        name="schools"
                                    >
                                    </pillbox>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable';

    var fieldObj = {
        id: 0,
        title: "Νέο πεδίο",
        type: 0,
        validators: [],
        listvalues: "",
        sort_id: 0,
    }

    var notes;

    export default {
        components: {
            draggable,
        },
        props: {
            parse: {
                type: Boolean,
                default: false,
            },
            parsetitle: {
                type: String,
                default: "Νέα φόρμα",
            },
            parsenotes: {
                type: String,
            },
            parseobj: {
                type: Array,
            },
            schools: Array,
            categories: Array,
            multiple: Boolean,
        },
        mounted() {
            console.log('Component mounted.')
            /*if (this.parse === true) {
                this.title = this.parsetitle
                this.fields = this.parseobj
            }*/

        },
        data: function() {
            if (this.parse) {
                var maxid = 0
                var maxsortid = 0

                for (const [key, value] of Object.entries(this.parseobj)) {
                    if (maxid < value.id) {
                        maxid = value.id
                    }
                    if (maxsortid < value.sort_id) {
                        maxsortid = value.sort_id
                    }
                }

                return {
                    title: this.parsetitle,
                    notes: this.parsenotes,
                    fields: this.parseobj,
                    cur_id: maxid,
                    cur_sort_id: maxsortid,
                }
            }
            return {
                title: "Νέα φόρμα",
                notes: "",
                fields: [JSON.parse( JSON.stringify( fieldObj ) )],
                cur_id: 0,
                cur_sort_id: 0,
            }
        },
        methods: {
            addField: function() {
                this.cur_id++;
                this.cur_sort_id++;
                fieldObj.id = this.cur_id;
                fieldObj.sort_id = this.cur_sort_id;
                this.fields.push(JSON.parse( JSON.stringify( fieldObj ) ));
            },

            delField: function(id) {
                var removeIndex = this.fields.map(function(item) { return item.id; })
                       .indexOf(id);

                ~removeIndex && this.fields.splice(removeIndex, 1);
            },

            dragEnded: function(e) {
                [this.$refs['vform-fields'][e.oldIndex].field_id,
                 this.$refs['vform-fields'][e.newIndex].field_id] = [this.$refs['vform-fields'][e.newIndex].field_id,
                                                                     this.$refs['vform-fields'][e.oldIndex].field_id];
            }
        }
    }
</script>
