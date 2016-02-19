<!--<script type="x/template" id="contact-template">-->
<template id="contact-template">
    <tr>
        <td v-show="!editing">@{{ contact.name }}</td>
        <td v-else>
            <input value="@{{ contact.name }}" v-model="contact.name">
            <div v-if="validationErrors.name">@{{ validationErrors.name[0] }}</div>
        </td>
        <td v-show="!editing">@{{ contact.number }}</td>
        <td v-else>
            <input value="@{{ contact.number }}" v-model="contact.number">
            <div v-if="validationErrors.number">@{{ validationErrors.number[0] }}</div>
        </td>
        <td class="actions">
            <span v-show="!editing">
                <i class="fa fa-pencil edit" @click="editing = true"></i>
                <i class="fa fa-times delete" @click="deleteContact" v-show="!isLoading.delete && !errors.delete"></i>
                <i class="fa fa-spinner fa-pulse delete" v-show="isLoading.delete"></i>
                <i class="fa fa-exclamation-triangle error" v-show="errors.delete" title="An error has occurred"></i>
            </span>
            <span v-show="editing">
                <i class="fa fa-floppy-o save" @click="updateContact" ></i>
                <i class="fa fa-spinner fa-pulse" v-show="isLoading.update"></i>
                <i class="fa fa-exclamation-triangle error" v-show="errors.update" title="An error has occurred"></i>
                <span @click="editing = false" class="cancel">Cancel</span>
            </span>
        </td>
    </tr>
</template>
