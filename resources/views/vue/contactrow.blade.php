<!--<script type="x/template" id="contact-template">-->
<script type="x/template" id="contact-template">
    <tr>
        {{-- The name field --}}
        <td v-show="!(editing || isLoading.updateContact)">@{{ contact.name }}</td>
        <td v-else>
            {{-- While editing, show an input with the updatedContact vm --}}
            <input value="@{{ contact.name }}" v-model="updatedContact.name" @input="validate">
            {{-- show validation errors --}}
            <div v-show="validationErrors.name || validationErrors.number" class="validation-error">@{{ validationErrors.name }}</div>
        </td>

        {{-- The number field -> similar to name --}}
        <td v-show="!(editing || isLoading.updateContact)">@{{ contact.number }}</td>
        <td v-else>
            <input value="@{{ contact.number }}" v-model="updatedContact.number" @input="validate">
            <div v-show="validationErrors.name || validationErrors.number" class="validation-error">@{{ validationErrors.number }}</div>
        </td>

        {{-- Action buttons --}}
        <td class="actions">

            {{-- Default: delete and update --}}
            <span v-show="!(editing || isLoading.updateContact)" class="icons">
                <i class="fa fa-pencil edit" @click="startEditing"></i>
                <i class="fa fa-times delete" @click="showConfirmationBox = true" v-show="!isLoading.deleteContact && !errors.deleteContact"></i>
                <p class="error-message-bubble" v-if="showConfirmationBox">
                    Are you sure you want to delete this contact?
                    <br />
                    <span class="error-bubble-button" @click="handleDelete(contact)">Yes!</span>
                    <span class="error-bubble-button" @click="showConfirmationBox = false">No, cancel.</span>
                </p>
                <i class="fa fa-spinner fa-pulse delete" v-show="isLoading.deleteContact"></i>
                <i class="fa fa-exclamation-triangle error" v-show="errors.deleteContact" title="An error has occurred"></i>
            </span>

            {{-- Editing: save and cancel --}}
            <span v-show="editing || isLoading.updateContact">
                <i class="fa fa-floppy-o save" @click="handleUpdate" v-show="!isLoading.updateContact"></i>
                <i v-else class="fa fa-spinner fa-pulse" ></i>
                <i class="fa fa-exclamation-triangle error" v-show="errors.updateContact" title="An error has occurred"></i>
                <span @click="cancelEditing" class="cancel">Cancel</span>
            </span>
        </td>
    </tr>
</script>
