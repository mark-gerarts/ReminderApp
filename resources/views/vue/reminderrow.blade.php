<template id="reminderrow">
    <tr>
        <td v-if="reminder.contact_id">
            <span v-for="contact in sharedState.contacts | exactFilterBy reminder.contact_id in 'id'">
                @{{ contact.name }}
            </span>
        </td>
        <td v-else>@{{ reminder.recipient }}</td>
        <td>@{{ reminder.send_datetime.substr(0, reminder.send_datetime.length-3) }}</td>
        <td>@{{ reminder.message }}</td>
        <td>
            @{{ repeats[reminder.repeat_id-1] }}
            <span class="cancel-reminder" @click="showConfirmationBox = true" title="Cancel this reminder" v-if="!isLoading.cancelReminder"><i class="fa fa-times"></i></span>
            <span class="cancel-reminder visible-imp" v-else><i class="fa fa-spinner fa-pulse"></i></span>
            <p class="error-message-bubble reminder-bubble" v-if="showConfirmationBox">
                Do you want to cancel this reminder? Your credit will be refunded.
                <br />
                <span class="error-bubble-button" @click="cancelReminder(reminder)">Yes!</span>
                <span class="error-bubble-button" @click="showConfirmationBox = false">No.</span>
            </p>
        </td>
    </tr>
</template>
