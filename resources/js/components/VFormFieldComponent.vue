<template>
    <div>
        <div class="d-flex justify-content-between">
                <i
                class="fas fa-align-justify handle mb-2"
                data-toggle="tooltip"
                data-placement="top"
                title="Μετακίνηση"
                ></i>
                <i
                class="fas fa-times"
                data-toggle="tooltip"
                data-placement="top"
                title="Διαγραφή πεδίου"
                @click="emitDelete"></i>
        </div>
        <div>
            <div class="form-row">
                <label for="fieldtitleid" class="col-3 col-form-label">Τίτλος πεδίου:</label>
                <div class="col-9 align-self-center">
                    <editable-text :edittext.sync="title" :fid="'field['+field_id+'][title]'"></editable-text>
                </div>
            </div>
            <div class="form-row">
                <label for="fieldtitleid" class="col-3 col-form-label">Τίτλος πεδίου:</label>
                <div class="col-9 align-self-center">
                    <select
                    :name="'field['+field_id+'][type]'"
                    v-model="cbselected"
                    >
                        <option
                        v-for="option in options"
                        :value="option.id"
                        :key="option.id"
                        >
                            {{ option.value }}
                        </option>
                    </select>
                </div>
            </div>
            <div v-if="this.cbselected > 1 && this.cbselected < 5">
                <editable-list
                :cbselected="cbselected"
                :edittext.sync="dlistvalues">
                </editable-list>

                <input type="hidden" :name="'field['+field_id+'][values]'" :value="dlistvalues"/>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['value', 'id', 'type', 'listvalues'],
        watch: {
            title: function(value) {
                this.$emit('update:value', value);
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        data: function() {
            return {
                title: this.value ? this.value : "Νέο πεδίο",
                cbselected: this.type,
                options: [
                    {
                        id: 0,
                        value: "Πεδίο κειμένου"
                    },
                    {
                        id: 1,
                        value: "Περιοχή κειμένου"
                    },
                    {
                        id: 2,
                        value: "Επιλογή ενός από πολλά"
                    },
                    {
                        id: 3,
                        value: "Πολλαπλή επιλογή"
                    },
                    {
                        id: 4,
                        value: "Λίστα επιλογών"
                    },
                    {
                        id: 5,
                        value: "Ανέβασμα αρχείου"
                    },
                    {
                        id: 6,
                        value: "Ημερομηνία"
                    },
                    {
                        id: 7,
                        value: "Αριθμός"
                    },
                    {
                        id: 8,
                        value: "Τηλέφωνο"
                    },
                    {
                        id: 9,
                        value: "E-mail"
                    },
                    {
                        id: 10,
                        value: "Διεύθυνση ιστοσελίδας"
                    },

                ],
                dlistvalues: this.listvalues,
                field_id: this.id,
            }
        },
        methods: {
            emitDelete: function() {
                this.$emit('delfield', this.id);
            },
        }
    }
</script>
