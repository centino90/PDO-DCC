import editMode from '../stores/editMode'

export default () => ({
    init() {
        editMode().on = !editMode().on
        window.Alpine.store('editMode', editMode)
    },
    isEditMode: editMode().on,

    trigger: {
        ['@click']() {
            this.isEditMode = !this.isEditMode
            editMode().on = editMode().on
        },
    },

    input: {
        specified: false,
        trigger: {
            ['@click']() {
                this.input.specified = !this.input.specified
            }
        },
        ['x-show']() {
            return this.input.specified
        },
    },

    inputSelectGroup: {
        specified: false,
        trigger: {
            ['@click']() {
                this.inputSelectGroup.specified = !this.inputSelectGroup.specified
            }
        },
        children: {
            input: {
                ['x-show']() {
                    return this.inputSelectGroup.specified
                },
            },
            select: {
                ['x-show']() {
                    return !this.inputSelectGroup.specified
                },
            }
        }
    }
})